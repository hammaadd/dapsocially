<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Event;
use App\Models\User\Venue;
use App\Models\Location;
use App\Models\User\Attached_Account;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Atymic\Twitter\Facade\Twitter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Square\Http\HttpRequest;

class AccountController extends Controller
{
    protected $hepler, $fb;
    public function __construct()
    {
        if(session_status() === PHP_SESSION_NONE):
            session_start();
        endif;
        $this->fb = new Facebook(array(
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v11.0',
        ));
        $this->helper = $this->fb->getRedirectLoginHelper();
        $this->middleware('auth');

    }
    public function index()
    {
        $account=Attached_Account::where('user_id',Auth::user()->id)->first();

       if($account){
        $events = Event::where('created_by', '=', Auth::user()->id)->take(6)->get();
        $venues=Venue::where('created_by', '=', Auth::user()->id)->take(3)->get();
        $locations=Location::all();

        return view('users.content.myaccount',compact('events','venues','locations'));
       }
       else{
                return redirect()->route('attach.social.account');
       }
    }
    public function search_Event(Request $request)
    {


        $venues=[];
        $events=[];
        $locations=[];

        if(!is_null($request->keyword) && !is_null($request->location)){
        $events=Event::where('created_by', '=', Auth::user()->id)->where('hashtag','=',$request->keyword)->where('location','=',$request->location)->get();




    }
    elseif(is_null($request->keyword) && !is_null($request->location) ){
        $events=Event::where('created_by', '=', Auth::user()->id)->where('location','=',$request->location)->get();


    }
        $locations = Location::all();
        return view('users.content.events', compact('events', 'locations'));

    }
    public function attach_account()
    {
        $permissions = ['user_posts','pages_show_list','pages_read_engagement']; // Optional permissions
        $loginURL = $this->helper->getLoginUrl(env('FACEBOOK_REDIRECT_URL'), $permissions);
            $csrfState = csrf_token() ;
            $url = 'https://open-api.tiktok.com/platform/oauth/connect/';

            $url .= '?client_key='.env('TIKTOK_CLIENT_KEY');
            $url .= '&scope=user.info.basic,video.list';
            $url .= '&response_type=code';
            $url .= '&redirect_uri='.env('TIKTOK_SERVER_ENDPOINT_REDIRECT');
            $url .= '&state='.$csrfState;
        // Render Facebook login button
        $output = $loginURL;


        return view('users.content.addsocialaccount',['url'=>$output,'tt_url'=>$url]);
    }

    public function getTTtoken(Request $request){
        if(!isset($request->error)){
            $url = 'https://open-api.tiktok.com/platform/oauth/access_token/';

            $url .= '?client_key='.env('TIKTOK_CLIENT_KEY');
            $url .= '&scope=user.info.basic,video.list';
            $url .= '&code='.$request->code;
            $url .= '&grant_type=authorization_code';
            $response = Http::get($url);
            dd($response);
        }    
        
    }

     public function redirectToFacebook()
     {

         return Socialite::driver('facebook')->redirect();
     }

     public function getFbToken(){
        try { 
            $accessToken = $this->helper->getAccessToken();
            $accessToken = $accessToken->getValue();
            $response = $this->fb->get(
                '/me',
                $accessToken
              );

            $data = $response->getDecodedBody();
            Session::put('fb_id',$data['id']);
            Session::put('fb_token',$accessToken);
            Attached_Account::updateOrCreate(
                ['verified_acc'=>'facebook', 'user_id'=>Auth::id()],
                ['token'=>$accessToken,'user_social_id'=>$data['id']]
            );
               
   
           Session::flash('message', 'Facebook Attached Successfully');
        } catch(FacebookResponseException $e) {
            //  echo 'Graph returned an error: ' . $e->getMessage();
            Session::flash('error', 'Unable to add contact support for help.');
            return redirect()->route('attach.social.account');
        } catch(FacebookSDKException $e) {
            //echo 'Facebook SDK returned an error: ' . $e->getMessage();
            Session::flash('error', 'Unable to add contact support for help.');
            return redirect()->route('attach.social.account');
        }

          
        return redirect()->route('my.account');



     }


     public function attachTwitter(){
        $token = Twitter::getRequestToken(route('get.token.twitter'));

        if (isset($token['oauth_token_secret'])) {
            $url = Twitter::getAuthenticateUrl($token['oauth_token']);
    
            Session::put('oauth_state', 'start');
            Session::put('oauth_request_token', $token['oauth_token']);
            Session::put('oauth_request_token_secret', $token['oauth_token_secret']);
    
            
            return Redirect::to($url);
        }
    
        // return Redirect::route('twitter.error');
     }


    

     public function getTwitterToken(){
        if (Session::has('oauth_request_token')) {
            $twitter = Twitter::usingCredentials(session('oauth_request_token'), session('oauth_request_token_secret'));
            $token = $twitter->getAccessToken(request('oauth_verifier'));
    
            if (!isset($token['oauth_token_secret'])) {
                echo "Error";
                // return Redirect::route('twitter.error')->with('flash_error', 'We could not log you in on Twitter.');
            }
    
            // use new tokens
            $twitter = Twitter::usingCredentials($token['oauth_token'], $token['oauth_token_secret']);
            $credentials = $twitter->getCredentials();
    
            if (is_object($credentials) && !isset($credentials->error)) {
    
                // This is also the moment to log in your users if you're using Laravel's Auth class
                // Auth::login($user) should do the trick.
    
                Session::put('access_token', $token);
                $data = Session::get('access_token');
                $data2 = json_encode($data);
                Attached_Account::updateOrCreate(
                    ['verified_acc'=>'twitter', 'user_id'=>Auth::id()],
                    ['token'=>$data2,'user_social_id'=>$data['user_id']]
                );

                $tweets =  Twitter::getSettings(['response_format' => 'json']);
                
                $tweets = json_decode($tweets);

                Session::put('tw_screen_name',$tweets->screen_name);
                //$tweets  = Twitter::getUserTimeline(['screen_name'=>$tweets->screen_name]);
               
                // dd($tweets);
                return redirect()->route('attach.social.account');
                // return Redirect::to('/')->with('notice', 'Congrats! You\'ve successfully signed in!');
            }
        }

        
    
        // return Redirect::route('twitter.error')
        //         ->with('error', 'Crab! Something went wrong while signing you up!');
     }

     public function searchTweet(Request $request){
        $q = $request->q;
        $tweets = Twitter::getSearch(['count'=>'10','q'=>$q]);

        // $tweets = Twitter::getUsers(['screen_name'=>Session::get('tw_screen_name')]);
        // $tweets  = Twitter::getUserTimeline(['count'=>'5','screen_name'=>Session::get('tw_screen_name')]);

        dd($tweets);
     }


}
