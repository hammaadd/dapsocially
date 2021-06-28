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

class AccountController extends Controller
{
    protected $hepler, $fb;
    public function __construct()
    {
        session_start();
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
        $account=Attached_Account::where('user_id',Auth::user()->id)->get();

       if(count($account)<1){
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
        $permissions = ['email','user_posts','pages_show_list','user_gender']; // Optional permissions 
        $loginURL = $this->helper->getLoginUrl(env('FACEBOOK_REDIRECT_URL'), $permissions); 
        
        // Render Facebook login button 
        $output = $loginURL;


        return view('users.content.addsocialaccount',['url'=>$output]);
    }

     public function redirectToFacebook()
     {

         return Socialite::driver('facebook')->redirect();
     }

     public function getFbToken(){    
        try { 
            $accessToken = $this->helper->getAccessToken(); 
            $response = $this->fb->get(
                '/me',
                $accessToken->getValue()
              );

            $data = $response->getDecodedBody();
            Session::put('fb_id',$data['id']);

        } catch(FacebookResponseException $e) { 
             echo 'Graph returned an error: ' . $e->getMessage(); 
              exit; 
        } catch(FacebookSDKException $e) { 
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
              exit;
        }

          Attached_Account::updateOrCreate(
             ['verified_acc'=>'facebook', 'user_id'=>Auth::id()],
             ['token'=>$accessToken->getValue(),'user_social_id'=>$data['id']]
         );
            Session::put('fb_token',$accessToken->getValue());
            
        
          return redirect()->route('my.account');
 


     }

}
