<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Event;
use App\Models\User\Venue;
use App\Models\Location;
use App\Models\User;
use App\Models\User\Attached_Account;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $account=Attached_Account::where('user_id',Auth::user()->id)->get();

       if(count($account)>1){
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
        dd(Auth::user());
        //return view('users.content.addsocialaccount');
    }

     public function redirectToFacebook()
     {

         return Socialite::driver('facebook')->redirect();
     }

}
