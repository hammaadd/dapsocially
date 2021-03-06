<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\User\Attached_Account;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    ///protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {

        //  oauth_request_token
        //  oauth_request_token_secret
        //  access_token
        //  tw_screen_name

        //Set the twitter session after login





        if ($user->hasRole('superadministrator')) {
            return redirect()->route('dashboard');
        } elseif ($user->hasRole('user') && $user->isactive == 1) {

            return redirect()->route('my.account');
        }
    }
    protected function logout(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        // return $request->wantsJson()
        //     ? new JsonResponse([], 204)
        //     : redirect('/admin/login');


        if ($user->hasRole('superadministrator')) {
            return redirect('/admin/login');
        } elseif ($user->hasRole('user')) {
            return redirect('signin');
        }
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        $user = Socialite::driver("google")->stateless()->user();
        $this->_registerOrLoginUser($user, 'google');
    }
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->fields([
            'first_name', 'last_name', 'email', 'gender', 'birthday', 'user_posts'
        ])->scopes([
            'email', 'user_birthday'
        ])->redirect();
    }
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->fields([
            'first_name', 'last_name', 'email', 'gender', 'birthday', 'user_posts'
        ])->user();

        //dd($user);
        $this->_registerOrLoginUser($user, 'facebook');
    }
    protected function _registerOrLoginUser($data, $attached_account)
    {
        // dd($data);
        $user = User::where('email', '=', $data->email)->first();
        // Session::put('fb_token',$data->token);
        // Session::put('user_id',$data->id);
        if (!$user && Auth::user()) {
            $ac = new Attached_Account();
            $ac->user_id = Auth::user()->id;
            $ac->verified_acc = $attached_account;
            $ac->token = $data->token;
            $ac->user_social_id = $data->id;
            $ac->save();
            //return redirect()->route('my.account');
        } else if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->image = $data->avatar;
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


        // dd(Session::get('fb_token'));
        // return redirect()->route('my.account');
    }
}
