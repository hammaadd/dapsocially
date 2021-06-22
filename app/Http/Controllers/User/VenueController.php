<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Order;
use App\Models\Payment_Plans;
use App\Models\User;
use App\Models\User\Venue;
use App\Models\User\Collect_Venue_Htag;
use App\Models\Venue_Social_Post;

use App\Notifications\OrdersNotifications;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Notification;

class VenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $P_plans = Payment_Plans::all();
        return view('users.content.add-venue', compact('P_plans'));
    }
    public function venue()
    {

        $locations = Location::all();
        $loc = [];
        foreach ($locations as $location) {
            if (Arr::has($loc, $location->address)) {
            } else {
                $loc = Arr::add($loc, $location->address, $location->address);
            }
        }
        $locations = $loc;
        $venues = Venue::all();
        return view('users.content.venues', compact('locations', 'venues'));
    }

    public function add_venue(Request $request)
    {
        $request->validate([
            'vname' => 'required',
            'e_descrip' => 'required',
            'cover_img' => 'required',
            'country' => 'required',

            'loc_address' => 'required',
            'locality' => 'required',
            'state' => 'required',
            'h_tag' => 'required',
            'm_dap_wall' => 'required',
            'wall_bg_img' => 'required',
            's_date' => 'required',
            's_time' => 'required',
            'e_date' => 'required',

            'e_date' => 'required',
            'e_time' => 'required',
            'h_tags' => 'required|min:1',
            //    'c_posts'=>'sometimes',
            //    'p_fb'=>'required_with:c_posts,on'
        ]);


        $location = new Location();
        $location->country = $request->country;
        $location->state = $request->state;
        $location->city = $request->locality;
        $location->address = $request->loc_address;
        $location->lng = $request->longitude;
        $location->lat = $request->latitude;
        $location->save();
        $venue = new Venue();
        $venue->venue_name = $request->vname;
        $venue->location_id = $location->id;
        if ($request->hasFile('cover_img')) {
            $coverImagename = $request->file('cover_img');
            $coverImagename = str_replace(' ', '', time() . '-' . $coverImagename->getClientOriginalName());

            $request->cover_img->move(public_path("Users/VenueImages"), $coverImagename);

            $venue->c_image = $coverImagename;
        }
        if ($request->hasFile('wall_bg_img')) {
            $bgImagename = $request->file('wall_bg_img');
            $bgImagename = str_replace(' ', '', time() . '-' . $bgImagename->getClientOriginalName());

            $request->wall_bg_img->move(public_path("Users/VenueImages"), $bgImagename);

            $venue->wall_bg_image = $bgImagename;
        }


        $venue->v_description = $request->e_descrip;
        $venue->hashtag = $request->h_tag;
        $venue->approve_htag = $request->app_htag;
        $venue->wall_location_msg = $request->m_dap_wall;
        $venue->start_date = $request->s_date;
        $venue->start_time = $request->s_time;
        $venue->end_date = $request->e_date;
        $venue->end_time = $request->e_time;
        $venue->created_by = Auth::user()->id;
        $venue->save();
        $p=Payment_Plans::where('id',$request->plan)->first();
        $odr=new Order();
        $odr->order_type="venue";
        $odr->order_status="Pending";
        $odr->account_type=$p->name;
        $odr->venue_id=$venue->id;

        $odr->user_id=Auth::user()->id;
        $odr->total_payment=$p->price;
        $odr->payment_plan_id=$request->plan;
        $odr->save();

        User::where('id',Auth::user()->id)->update(['account_type'=>$p->name]);
        $user =User::whereHas(
            'roles', function($q){
                $q->where('name', 'superadministrator');
            }
        )->get();

        $details = [
            'greeting' => 'Hi ',
            'body' => 'A new Order is placed by user named '.Auth::user()->name.' ',
            'thanks' => 'Thank you ',
        ];
        Notification::send($user, new OrdersNotifications($details));
        foreach ($request->h_tags as $h_tag) {
            $hashtag = new Collect_Venue_Htag();
            $hashtag->account_name = $h_tag;
            $hashtag->venue_id = $venue->id;
            $hashtag->save();
        }
        Session::flash('message', 'Venue added succesfully succesfully');

        return back();
    }

    public function load_more_venues()
    {
        $venues=Venue::all();
        $locations=Location::all();
        return view('users.content.venues',compact('venues','locations'));

    }
    public function search_my_Venue(Request $request)
    {


        $venues = [];
        $events = [];
        $locations = [];

        if (!is_null($request->keyword) && !is_null($request->location)) {

            $locations = Location::where('address', '=', $request->location)->get();

            foreach ($locations as $location) {
                if (!is_null(Venue::where('created_by', '=', Auth::user()->id)->where('location_id', '=', $location->id)->where('hashtag', '=', $request->keyword)->first())) {
                    $venues = Arr::add($venues, $location->id, Venue::where('location_id', '=', $location->id)->where('hashtag', '=', $request->keyword)->first());
                }
            }
        } elseif (is_null($request->keyword) && !is_null($request->location)) {

            $locations = Location::where('address', '=', $request->location)->get();

            foreach ($locations as $location) {



                if (!is_null(Venue::where('created_by', '=', Auth::user()->id)->where('location_id', '=', $location->id)->first())) {
                    $venues = Arr::add($venues, $location->id, Venue::where('location_id', '=', $location->id)->first());
                }
            }
        }


    //     $venues=[];
    //     $events=[];
    //     $locations=[];

    //     if(!is_null($request->keyword) && !is_null($request->location)){

    //     $locations=Location::where('address','=',$request->location)->get();

    //     foreach($locations as $location){
    //         if(!is_null(Venue::where('created_by', '=', Auth::user()->id)->where('location_id','=',$location->id)->where('hashtag','=',$request->keyword)->first())){
    //         $venues=Arr::add($venues,$location->id,Venue::where('location_id','=',$location->id)->where('hashtag','=',$request->keyword)->first());
    //         }
    //     }



    // }
    // elseif(is_null($request->keyword) && !is_null($request->location) ){

    //     $locations=Location::where('address','=',$request->location)->get();

    //     foreach($locations as $location){



    //         if(!is_null(Venue::where('created_by', '=', Auth::user()->id)->where('location_id','=',$location->id)->first())){
    //         $venues=Arr::add($venues,$location->id,Venue::where('location_id','=',$location->id)->first());
    //         }
    //     }

    // }


        $locations = Location::all();
        return view('users.content.myvenues', compact('venues', 'locations'));
    }
    public function search_Venue(Request $request)
    {


        $venues = [];
        $events = [];
        $locations = [];

        if (!is_null($request->keyword) && !is_null($request->location)) {

            $locations = Location::where('address', '=', $request->location)->get();

            foreach ($locations as $location) {
                if (!is_null(Venue::where('location_id', '=', $location->id)->where('hashtag', '=', $request->keyword)->first())) {
                    $venues = Arr::add($venues, $location->id, Venue::where('location_id', '=', $location->id)->where('hashtag', '=', $request->keyword)->first());
                }
            }
        } elseif (is_null($request->keyword) && !is_null($request->location)) {

            $locations = Location::where('address', '=', $request->location)->get();

            foreach ($locations as $location) {



                if (!is_null(Venue::where('location_id', '=', $location->id)->first())) {
                    $venues = Arr::add($venues, $location->id, Venue::where('location_id', '=', $location->id)->first());
                }
            }
        }
        $locations = Location::all();
        $loc=[];
        foreach($locations as $location ){
            if (Arr::has($loc,$location->address)) {

               }
               else{
                $loc=Arr::add($loc,$location->address,$location->address);

               }
        }
        $locations=$loc;
        return view('users.content.venues', compact('venues', 'locations'));
    }
    public function my_venues()
    {

        $locations=Location::all();
        $loc=[];
        foreach($locations as $location ){
            if (Arr::has($loc,$location->address)) {

               }
               else{
                $loc=Arr::add($loc,$location->address,$location->address);

               }
        }
        $locations=$loc;
        $venues = Venue::where('created_by', '=', Auth::user()->id)->take(9)->get();
        return view('users.content.myvenues', compact('locations', 'venues'));
    }

public function load_my_venues()

    {
        $venues = Venue::where('created_by', '=', Auth::user()->id)->get();

        $locations=Location::all();
        $loc=[];
        foreach($locations as $location ){
            if (Arr::has($loc,$location->address)) {

               }
               else{
                $loc=Arr::add($loc,$location->address,$location->address);

               }
        }
        $locations=$loc;
        return view('users.content.myvenues', compact('venues', 'locations'));
    }
    public function delete_myvenue(Venue $venue)
    {

        $del = Venue::find($venue->id);
        if (!is_null(public_path('Users/VenueImages/' . $venue->c_image))) {
            File::delete(public_path('venues/VenueImages/' . $venue->c_image));
        }
        if (!is_null(public_path('Users/VenueImages/' . $venue->c_image))) {
            File::delete(public_path('Users/VenueImaVenue' . $venue->wall_bg_image));
        }

        $del->delete();
        $vTags = Collect_Venue_Htag::where('venue_id', $venue->social_posts)->get();
        if (!is_null(Collect_Venue_Htag::where('venue_id', $venue->social_posts)->get())) {
            foreach ($vTags as $vTag) {
                $vTag->delete();
            }
        }
        $del=Venue::find($venue->id);
        if(!is_null(public_path('Users/VenueImages/'.$venue->c_image))){
            File::delete(public_path('venues/VenueImages/'.$venue->c_image));
        }
        if(!is_null(public_path('Users/VenueImages/'.$venue->c_image)))
        {
            File::delete(public_path('Users/VenueImaVenue'.$venue->wall_bg_image));
        }

        $del->delete();
        $vTags=Collect_Venue_Htag::where('venue_id',$venue->social_posts)->get();
        if(!is_null(Collect_Venue_Htag::where('venue_id',$venue->social_posts)->get())){
        foreach($vTags as $vTag){
                $vTag->delete();
            }
        }
        return back();
    }
    // public function edit_vavenueenue(Venue $venue)
    // {

    //     $location=Location::where('idvenue', $venue->location_id)->first();
    //     return view('Venue s.content.editvenue');
    // }
    public function edit_vanue(Venue $venue)
    {


        $location = Location::where('id', '=', $venue->location_id)->first();
        $venue_htags = Collect_Venue_Htag::where('venue_id', '=', $venue->id)->get();
        $odr=Order::where('venue_id',$venue->id)->get();
        $payment_details=Payment_Plans::where('id',$odr->payment_plan_id)->first();


        return view('users.content.editvenue', compact('venue', 'location', 'venue_htags','payment_details'));
    }
    // public function update_venue(Request $request, Venue $venue)
    // {
    //     $request->validate([
    //         'vname' => 'required',
    //         'e_descrip' => 'required',

    //         'country' => 'required',
    //         'loc_address' => 'required',
    //         'locality' => 'required',
    //         'state' => 'required',
    //         'h_tag' => 'required',
    //         'm_dap_wall' => 'required',

    //         's_date' => 'required',
    //         's_time' => 'required',
    //         'e_date' => 'required',

    //         'e_date' => 'required',
    //         'e_time' => 'required',
    //         'h_tags' => 'required|min:1',
    //         //    'c_posts'=>'sometimes',
    //         //    'p_fb'=>'required_with:c_posts,on'
    //     ]);

    //     if ($request->hasFile('cover_img')) {
    //         $coverImagename = $request->file('cover_img');
    //         $coverImagename = str_replace(' ', '', time() . '-' . $coverImagename->getClientOriginalName());
    //         File::delete(public_path('Users/VenueImages/' . $venue->c_image));
    //         $request->cover_img->move(public_path("Users/VenueImages"), $coverImagename);

    //     $location=Location::where('id', '=', $venue->location_id)->first();
    //     $venue_htags=Collect_Venue_Htag::where('venue_id', '=', $venue->id)->get();

    //     return view('users.content.editvenue',compact('venue','location','venue_htags'));


    // }
    public function update_venue(Request $request, Venue $venue)
    {
        $request->validate([
            'vname' => 'required',
            'e_descrip' => 'required',

            'country' => 'required',
            'loc_address'=>'required',
            'locality'=>'required',
            'state'=>'required',
            'h_tag'=>'required',
           'm_dap_wall'=>'required',

           's_date'=>'required',
           's_time'=>'required',
           'e_date'=>'required',

           'e_date'=>'required',
           'e_time'=>'required',
           'h_tags'=>'required|min:1',
        //    'c_posts'=>'sometimes',
        //    'p_fb'=>'required_with:c_posts,on'
            ]);

            if ($request->hasFile('cover_img') ) {
                $coverImagename=$request->file('cover_img');
                $coverImagename=str_replace(' ','',time().'-'.$coverImagename->getClientOriginalName());
                File::delete(public_path('Users/VenueImages/'.$venue->c_image));
                $request->cover_img->move(public_path("Users/VenueImages"),$coverImagename);

                Venue::where('id',$venue->id)->update(['c_image' => $coverImagename,'venue_name'=>$request->vname,'v_description'=>$request->e_descrip,'hashtag'=>$request->h_tag,'approve_htag'=>$request->app_htag,
                'start_time'=>$request->s_time,'start_date'=>$request->s_date,'end_time'=>$request->e_time,'end_date'=>$request->e_date,'created_by'=>Auth::user()->id]);

            }
            if ($request->hasFile('wall_bg_img') ) {
                $coverImagename=$request->file('wall_bg_img');
                $coverImagename=str_replace(' ','',time().'-'.$coverImagename->getClientOriginalName());
                File::delete(public_path('venues/VenueImages/'.$venue->wall_bg_img));
                $request->wall_bg_img->move(public_path("Users/VenueImages"),$coverImagename);

                Venue::where('id',$venue->id)->update(['wall_bg_img' => $coverImagename,'venue_name'=>$request->vname,'v_description'=>$request->e_descrip,'hashtag'=>$request->h_tag,'approve_htag'=>$request->app_htag,
                'start_time'=>$request->s_time,'start_date'=>$request->s_date,'end_time'=>$request->e_time,'end_date'=>$request->e_date,'created_by'=>Auth::user()->id]);

            }
            if(!is_null($request->longitude && $request->latitude))
            {

                Location::where('id',$venue->location_id)->update(['country'=>$request->country,'state'=>$request->state,'city'=>$request->locality,'address'=>$request->loc_address,'lng'=>$request->longitude,'lat'=>$request->latitude]);
            }
            else{
                Location::where('id',$venue->location_id)->update(['country'=>$request->country,'state'=>$request->state,'city'=>$request->locality,'address'=>$request->loc_address]);
            }

            $vTags=Collect_Venue_Htag::where('venue_id',$venue->social_posts)->get();
            foreach($vTags as $vTag){
                $vTag->delete();

            }
            foreach($request->h_tags as $h_tag){
                $hashtag=new Collect_Venue_Htag();
               $hashtag->account_name=$h_tag;
               $hashtag->venue_id=$venue->id;
               $hashtag->save();

            }
            Venue::where('id',$venue->id)->update(['venue_name'=>$request->vname,'v_description'=>$request->e_descrip,'hashtag'=>$request->h_tag,'approve_htag'=>$request->app_htag,
            'start_time'=>$request->s_time,'start_date'=>$request->s_date,'end_time'=>$request->e_time,'end_date'=>$request->e_date,'created_by'=>Auth::user()->id]);


            return redirect()->route('my.venues');



    }


    //         Venue::where('id', $venue->id)->update([
    //             'c_image' => $coverImagename, 'venue_name' => $request->vname, 'v_description' => $request->e_descrip, 'hashtag' => $request->h_tag, 'approve_htag' => $request->app_htag,
    //             'start_time' => $request->s_time, 'start_date' => $request->s_date, 'end_time' => $request->e_time, 'end_date' => $request->e_date, 'created_by' => Auth::user()->id
    //         ]);
    //     }
    //     if ($request->hasFile('wall_bg_img')) {
    //         $coverImagename = $request->file('wall_bg_img');
    //         $coverImagename = str_replace(' ', '', time() . '-' . $coverImagename->getClientOriginalName());
    //         File::delete(public_path('venues/VenueImages/' . $venue->wall_bg_img));
    //         $request->wall_bg_img->move(public_path("Users/VenueImages"), $coverImagename);

    //         Venue::where('id', $venue->id)->update([
    //             'wall_bg_img' => $coverImagename, 'venue_name' => $request->vname, 'v_description' => $request->e_descrip, 'hashtag' => $request->h_tag, 'approve_htag' => $request->app_htag,
    //             'start_time' => $request->s_time, 'start_date' => $request->s_date, 'end_time' => $request->e_time, 'end_date' => $request->e_date, 'created_by' => Auth::user()->id
    //         ]);
    //     }
    //     if (!is_null($request->longitude && $request->latitude)) {

    //         Location::where('id', $venue->location_id)->update(['country' => $request->country, 'state' => $request->state, 'city' => $request->locality, 'address' => $request->loc_address, 'lng' => $request->longitude, 'lat' => $request->latitude]);
    //     } else {
    //         Location::where('id', $venue->location_id)->update(['country' => $request->country, 'state' => $request->state, 'city' => $request->locality, 'address' => $request->loc_address]);
    //     }

    //     $vTags = Collect_Venue_Htag::where('venue_id', $venue->id)->get();

    //     foreach ($vTags as $vTag) {
    //         $vTag->delete();
    //     }


    //     foreach ($request->h_tags as $h_tag) {
    //         $hashtag = new Collect_Venue_Htag();
    //         $hashtag->account_name = $h_tag;
    //         $hashtag->venue_id = $venue->id;
    //         $hashtag->save();
    //     }
    //     Venue::where('id', $venue->id)->update([
    //         'venue_name' => $request->vname, 'v_description' => $request->e_descrip, 'hashtag' => $request->h_tag, 'approve_htag' => $request->app_htag,
    //         'start_time' => $request->s_time, 'start_date' => $request->s_date, 'end_time' => $request->e_time, 'end_date' => $request->e_date, 'created_by' => Auth::user()->id
    //     ]);


    //     return redirect()->route('my.venues');
    // }
}

