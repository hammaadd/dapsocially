<?php

namespace App\Http\Controllers\Auth;

ini_set("allow_url_fopen", 1);

use App\Models\User;
use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User\Attached_Account;

class SocailLoginController extends Controller
{
    public function facebookLogin(Request $request)
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function twitterLogin(Request $request)
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function instagramLogin(Request $request){

        $appId = config('services.instagram.client_id');
        $redirectUri = urlencode(config('services.instagram.redirect'));
        return redirect()->away("https://api.instagram.com/oauth/authorize?app_id={$appId}&redirect_uri={$redirectUri}&scope=user_profile,user_media&response_type=code");

    }


    public function handleInstagramCallback(Request $request)
    {

        $code = $request->code;
        if (empty($code)) {
            return redirect()->route('home')->with('error', 'Failed to login with Instagram.');
        }

        $appId = config('services.instagram.client_id');
        $secret = config('services.instagram.client_secret');
        $redirectUri = config('services.instagram.redirect');

        $client = new \GuzzleHttp\Client();

        // Get access token
        $response = $client->request('POST', 'https://api.instagram.com/oauth/access_token', [
        'form_params' => [
            'app_id' => $appId,
            'app_secret' => $secret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirectUri,
            'code' => $code,
        ]
        ]);

        if ($response->getStatusCode() != 200) {
            return redirect()->route('home')->with('error', 'Unauthorized login to Instagram.');
        }

        $content = $response->getBody()->getContents();
        $content = json_decode($content);



        $accessToken = $content->access_token;
        $userId = $content->user_id;


        // Get user info
        $response = $client->request('GET', "https://graph.instagram.com/me?fields=id,username,account_type&access_token={$accessToken}");

        $content = $response->getBody()->getContents();
        $oAuth = json_decode($content);
        $this->registerOrLoginUserInsta($oAuth, 'instagram', $accessToken, $userId);
        return redirect()->route('my.account');
    }

    public function handleFacebookCallback(Request $request)
    {
        $user = Socialite::driver('facebook')->stateless()->user();
        if($user)
        {
            $this->registerOrLoginUser($user, 'facebook');
            return redirect()->route('my.account');
        }
    }
    public function handletwitterCallback(Request $request)
    {
        $user = Socialite::driver('twitter')->user();
        if($user)
        {
            $this->registerOrLoginUser($user, 'twitter');
            return redirect()->route('my.account');
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        if($user)
        {
            $this->registerOrLoginUser($user, 'google');
            return redirect()->route('my.account');
        }

    }

    public function registerOrLoginUser($data, $attached_account)
    {

        $user = User::where('email', '=', $data->email)->first();
        //dd($user);
        if ($user) {
            $ac = new Attached_Account();
            $ac->user_id = $user->id;
            $ac->verified_acc = $attached_account;
            $ac->token = $data->token;
            // $fileContents = file_get_contents($data->avatar);
            // $imgName = time() . "_avatar.jpg";
            // $path = public_path() . '/user/profile/'.$imgName;
            // File::put($path, $fileContents);
            // $user->image = $imgName;
            $user->save();
            $ac->user_social_id = $data->id;
            $ac->save();
            Auth::login($user);
        } else if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            // $fileContents = file_get_contents($data->avatar);
            // $imgName = time() . "_avatar.jpg";
            // $path = public_path() . '/user/profile/'.$imgName;
            // $user->image = $imgName;
            // File::put($path, $fileContents);
            $user->isactive = 1;
            $user->password = Hash::make($data->name);
            $user->save();
            $user->attachRole('user');
            $ac = new Attached_Account();
            $ac->user_id = $user->id;
            $ac->verified_acc = $attached_account;
            $ac->token = $data->token;
            $ac->user_social_id = $data->id;
            $ac->save();
            Auth::login($user);
        }

    }

    public function registerOrLoginUserInsta($data, $attached_account, $accessToken, $IGID)
    {

        $user = User::where('username', '=', $data->username)->first();
        //dd($user);
        if ($user) {
            $ac = new Attached_Account();
            $ac->user_id = $user->id;
            $ac->verified_acc = $attached_account;
            $user->save();
            $ac->user_social_id = $IGID;
            $ac->token = $accessToken;
            $ac->save();
            Auth::login($user);
        } else if (!$user) {
            $email = $data->username.'@gmail.com';
            $user = new User();
            $user->name = $data->username;
            $user->email = $email;
            $user->username = $data->username;
            $user->isactive = 1;
            $user->password = Hash::make($data->username);
            $user->save();
            $user->attachRole('user');
            $ac = new Attached_Account();
            $ac->user_id = $user->id;
            $ac->verified_acc = $attached_account;
            $ac->token = $accessToken;
            $ac->user_social_id = $IGID;
            $ac->save();
            Auth::login($user);
        }

    }

    function curl_get_file_contents($URL)
            {
                $c = curl_init();
                curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($c, CURLOPT_URL, $URL);
                $contents = curl_exec($c);
                curl_close($c);

                if ($contents) return $contents;
                else return FALSE;
            }


}
