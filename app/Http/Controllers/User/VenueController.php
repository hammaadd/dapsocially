<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\FetchSocialWallVenuePosts;
use App\Models\Event_Social_Post;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Order;
use App\Models\Payment_Plans;
use App\Models\User;
use App\Models\User\Attached_Account;
use App\Models\User\Venue;
use App\Models\User\Collect_Venue_Htag;
use App\Models\Venue_Social_Post;

use App\Notifications\OrdersNotifications;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
use Atymic\Twitter\Facade\Twitter;

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
        $attach_acc = Attached_Account::where('user_id', Auth::user()->id)->where('verified_acc', 'facebook')->first();

        ///$attach_acc=Attached_Account::where('user_id',Auth::user()->id)->where('verified_acc','facebook')->first();
        $data = [];
        $tw_user = null;
        if (Auth::user()->facebook()) :
            $accestoken = Auth::user()->facebook()->token;
            $data = $this->getPages($accestoken);
            $this->page_data = $data['data'];
            $data = $data['data'];
            $accestoken = $attach_acc->token;
            $data = $this->getPages($accestoken);
            $this->page_data = $data['data'];
            $data = $data['data'];
        endif;

        if (Auth::user()->twitter()) :
            $tw_token = json_decode(Auth::user()->twitter()->token);
            Session::put('tw_screen_name', $tw_token->screen_name);
            $tw_user = $this->getTwUserProfile();

        endif;


        return view('users.content.add-venue', compact('P_plans', 'tw_user', 'data'));
    }

    public function getTwUserProfile()
    {
        $tw_attach_acc = json_decode(Auth::user()->twitter()->token);
        $screen_name = $tw_attach_acc->screen_name;

        //Set user credentials
        $twitter = Twitter::usingCredentials($tw_attach_acc->oauth_token, $tw_attach_acc->oauth_token_secret);
        $user = $twitter->getUsers(['screen_name' => $screen_name]);
        return $user;
    }

    public function venue()
    {

        $venues = Venue::all();


        return view('users.content.venues', compact('venues'));
    }

    public function add_venue(Request $request)
    {
        $request->validate([
            'vname' => 'required',
            'e_descrip' => 'required',
            'cover_img' => 'required',
            'country' => 'required',
            'plan' => 'required',
            'c' => 'required',
            'loc_address' => 'required',
            'locality' => 'required',
            'state' => 'required',
            'h_tag' => 'required',
            'm_dap_wall' => 'required',
            'wall_bg_img' => 'required',
            's_date' => 'required',
            's_time' => 'required',
            // 'h_tags' => 'required|min:1',
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


        $this->add_venue_social_posts($venue->id, $request);
        $p = Payment_Plans::where('id', $request->plan)->first();
        $odr = new Order();
        $odr->order_type = "venue";
        $odr->order_status = "Pending";
        $odr->account_type = $p->name;
        $odr->venue_id = $venue->id;
        $odr->user_id = Auth::user()->id;
        $odr->total_payment = $p->price;
        $odr->payment_plan_id = $request->plan;
        $odr->save();

        User::where('id', Auth::user()->id)->update(['account_type' => $p->name]);
        $user = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'superadministrator');
            }
        )->get();

        $details = [
            'greeting' => 'Hi ',
            'body' => 'A new Order is placed by user named ' . Auth::user()->name . ' ',
            'thanks' => 'Thank you ',
        ];
        // Notification::send($user, new OrdersNotifications($details));
        // foreach ($request->h_tags as $h_tag) {
        //     $hashtag = new Collect_Venue_Htag();
        //     $hashtag->account_name = $h_tag;
        //     $hashtag->venue_id = $venue->id;
        //     $hashtag->save();
        // }
        FetchSocialWallVenuePosts::dispatchAfterResponse($venue);

        Session::flash('message', 'Venue added succesfully succesfully');

        return back();
    }
    public function add_venue_social_posts($venue_id, Request $request)
    {
        $count = count($request->c);

        for ($i = 1; $i < $count; $i++) {
            if ($request->c[$i] == 'facebook') {
                foreach ($request->fb_page as $fb) {
                    $posts = new Venue_Social_Post();
                    $posts->platform = 'facebook';
                    $posts->page_name = $fb;
                    $posts->venue_id = $venue_id;
                    $posts->save();
                }

                $attach_acc = Attached_Account::where('user_id', Auth::user()->id)->where('verified_acc', 'facebook')->first();
                $accestoken = $attach_acc->token;
                $data = $this->getPages($accestoken);
                $data = $data['data'];

                foreach ($data as $page) {

                    Venue_Social_Post::where('venue_id', $venue_id)->where('platform', 'facebook')->update(['page_id' => $page['id']]);
                }
            }
            if ($request->c[$i] == 'insta') {
                $posts = new Venue_Social_Post();
                $posts->platform = $request->c[$i];
                $posts->page_name_id = $request->inp[1];
                $posts->venue_id = $venue_id;
                $posts->save();
            }
            if ($request->c[$i] == 'twitter') {
                $posts = new Venue_Social_Post();
                $posts->platform = $request->c[$i];
                $posts->page_name_id = $request->inp[2];
                $posts->venue_id = $venue_id;
                $posts->save();
            }
            if ($request->c[$i] == 'tiktok') {
                $posts = new Venue_Social_Post();
                $posts->platform = $request->c[$i];
                $posts->page_name_id = $request->inp[3];
                $posts->venue_id = $venue_id;
                $posts->save();
            }
        }
    }


    public function load_more_venues()
    {
        $venues = Venue::all();

        $locations = Location::all();
        $loc = [];
        foreach ($locations as $location) {
            if (Arr::has($loc, $location->address)) {
            } else {
                $loc = Arr::add($loc, $location->address, $location->address);
            }
        }
        $locations = $loc;
        $locationss = Location::all();
        $loc = [];
        foreach ($locationss as $location) {
            if (Arr::has($loc, $location->city)) {
            } else {
                $loc = Arr::add($loc, $location->city, $location->city);
            }
        }


        return view('users.content.venues', compact('venues', 'locations', 'loc'));
    }
    public function filter_location(Request $request)
    {
        if ($request->ajax()) {
            $locations = Location::where('city', $request->q)->get();
            $loc = [];
            foreach ($locations as $location) {
                if (Arr::has($loc, $location->address)) {
                } else {
                    $loc = Arr::add($loc, $location->address, $location->address);
                }
            }
            $locations = $loc;
            $data = '';
            foreach ($locations as $add) {
                $data .= '<option value="' . $add . '">' . $add . '</option>';
            }
            echo json_encode($data);
        }
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
        $locations = Location::all();
        $loc = [];
        foreach ($locations as $location) {
            if (Arr::has($loc, $location->address)) {
            } else {
                $loc = Arr::add($loc, $location->address, $location->address);
            }
        }
        $locations = $loc;
        $locationss = Location::all();
        $loc = [];
        foreach ($locationss as $location) {
            if (Arr::has($loc, $location->city)) {
            } else {
                $loc = Arr::add($loc, $location->city, $location->city);
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



        return view('users.content.myvenues', compact('venues', 'locations', 'loc'));
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
        $loc = [];
        foreach ($locations as $location) {
            if (Arr::has($loc, $location->address)) {
            } else {
                $loc = Arr::add($loc, $location->address, $location->address);
            }
        }
        $locations = $loc;
        $locationss = Location::all();
        $loc = [];
        foreach ($locationss as $location) {
            if (Arr::has($loc, $location->city)) {
            } else {
                $loc = Arr::add($loc, $location->city, $location->city);
            }
        }
        return view('users.content.venues', compact('venues', 'locations', 'loc'));
    }
    public function my_venues()
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
        $venues = Venue::where('created_by', '=', Auth::user()->id)->take(9)->get();
        $locationss = Location::all();
        $loc = [];
        foreach ($locationss as $location) {
            if (Arr::has($loc, $location->city)) {
            } else {
                $loc = Arr::add($loc, $location->city, $location->city);
            }
        }
        return view('users.content.myvenues', compact('locations', 'venues', 'loc'));
    }

    public function load_my_venues()

    {
        $venues = Venue::where('created_by', '=', Auth::user()->id)->get();

        $locations = Location::all();
        $loc = [];
        foreach ($locations as $location) {
            if (Arr::has($loc, $location->address)) {
            } else {
                $loc = Arr::add($loc, $location->address, $location->address);
            }
        }
        $locations = $loc;
        $locationss = Location::all();
        $loc = [];
        foreach ($locationss as $location) {
            if (Arr::has($loc, $location->city)) {
            } else {
                $loc = Arr::add($loc, $location->city, $location->city);
            }
        }
        return view('users.content.myvenues', compact('venues', 'locations', 'loc'));
    }
    public function delete_myvenue(Venue $venue)
    {


        $del = Venue::find($venue->id);
        if (!is_null(public_path('Users/VenueImages/' . $venue->c_image))) {
            File::delete(public_path('venues/VenueImages/' . $venue->c_image));
        }
        if (!is_null(public_path('Users/VenueImages/' . $venue->wall_bg_image))) {
            File::delete(public_path('Users/VenueImaVenue' . $venue->wall_bg_image));
        }


        $vTags = Collect_Venue_Htag::where('venue_id', $venue->id)->get();
        if (!is_null(Collect_Venue_Htag::where('venue_id', $venue->id)->get())) {
            foreach ($vTags as $vTag) {
                $vTag->delete();
            }
        }
        $Posts = Venue_Social_Post::where('venue_id', $venue->id)->get();
        if (!is_null(Venue_Social_Post::where('venue_id', $venue->id)->get())) {
            foreach ($Posts as $post) {
                $post->delete();
            }
        }

        $del->delete();
        Session::flash('message', 'Venue deleted succesfully succesfully');
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
        $odr = Order::where('venue_id', $venue->id)->first();

        $payment_details = Payment_Plans::where('id', $odr->payment_plan_id)->first();
        $P_plans = Payment_Plans::all();
        $posts = Venue_Social_Post::where('venue_id', $venue->id)->get();
        return view('users.content.editvenue', compact('venue', 'venue_htags', 'location', 'payment_details', 'P_plans', 'posts'));
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
            'loc_address' => 'required',
            'locality' => 'required',
            'state' => 'required',
            'h_tag' => 'required',
            'm_dap_wall' => 'required',
            'plan' => 'required',
            's_date' => 'required',
            's_time' => 'required',
            //    'e_date'=>'required',

            //    'e_date'=>'required',
            //    'e_time'=>'required',
            //    'h_tags'=>'required|min:1',
            //    'c_posts'=>'sometimes',
            //    'p_fb'=>'required_with:c_posts,on'
        ]);

        if ($request->hasFile('cover_img')) {
            $coverImagename = $request->file('cover_img');
            $coverImagename = str_replace(' ', '', time() . '-' . $coverImagename->getClientOriginalName());
            File::delete(public_path('Users/VenueImages/' . $venue->c_image));
            $request->cover_img->move(public_path("Users/VenueImages"), $coverImagename);

            Venue::where('id', $venue->id)->update([
                'c_image' => $coverImagename, 'venue_name' => $request->vname, 'v_description' => $request->e_descrip, 'hashtag' => $request->h_tag, 'approve_htag' => $request->app_htag,
                'start_time' => $request->s_time, 'start_date' => $request->s_date, 'end_time' => $request->e_time, 'end_date' => $request->e_date, 'created_by' => Auth::user()->id
            ]);
        }
        if ($request->hasFile('wall_bg_img')) {
            $coverImagename = $request->file('wall_bg_img');
            $coverImagename = str_replace(' ', '', time() . '-' . $coverImagename->getClientOriginalName());
            File::delete(public_path('venues/VenueImages/' . $venue->wall_bg_img));
            $request->wall_bg_img->move(public_path("Users/VenueImages"), $coverImagename);

            Venue::where('id', $venue->id)->update([
                'wall_bg_img' => $coverImagename, 'venue_name' => $request->vname, 'v_description' => $request->e_descrip, 'hashtag' => $request->h_tag, 'approve_htag' => $request->app_htag,
                'start_time' => $request->s_time, 'start_date' => $request->s_date, 'end_time' => $request->e_time, 'end_date' => $request->e_date, 'created_by' => Auth::user()->id
            ]);
        }
        if (!is_null($request->longitude && $request->latitude)) {

            Location::where('id', $venue->location_id)->update(['country' => $request->country, 'state' => $request->state, 'city' => $request->locality, 'address' => $request->loc_address, 'lng' => $request->longitude, 'lat' => $request->latitude]);
        } else {
            Location::where('id', $venue->location_id)->update(['country' => $request->country, 'state' => $request->state, 'city' => $request->locality, 'address' => $request->loc_address]);
        }

        $vTags = Collect_Venue_Htag::where('venue_id', $venue->id)->get();
        if ($vTags)
            foreach ($vTags as $vTag) {
                $vTag->delete();
            }
        $Posts = Venue_Social_Post::where('venue_id', $venue->id)->get();
        foreach ($Posts as $Post) {

            $Post->delete();
        }
        $this->update_venue_social_posts($venue->id, $request);
        // $h_tags = explode(' ',$request->h_tag);
        foreach ($request->h_tags as $h_tag) {
            $hashtag = new Collect_Venue_Htag();
            $hashtag->account_name = $h_tag;
            $hashtag->venue_id = $venue->id;
            $hashtag->save();
        }
        $plans = Payment_Plans::where('id', $request->plan)->first();
        Order::where('venue_id', $venue->id)->update(['account_type' => $plans->name, 'payment_plan_id' => $request->plan, 'total_payment' => $plans->price]);
        Venue::where('id', $venue->id)->update([
            'venue_name' => $request->vname, 'v_description' => $request->e_descrip, 'hashtag' => $request->h_tag, 'approve_htag' => $request->app_htag,
            'start_time' => $request->s_time, 'start_date' => $request->s_date, 'end_time' => $request->e_time, 'end_date' => $request->e_date, 'created_by' => Auth::user()->id
        ]);

        Session::flash('message', 'Venue updated succesfully succesfully');
        return back();
    }
    public function update_venue_social_posts($venue_id, Request $request)
    {
        $count = (is_array($request->c)) ? count($request->c) : 0;
        for ($i = 0; $i < $count; $i++) {
            if ($request->c[$i] == 'facebook') {
                $posts = new Venue_Social_Post();
                $posts->platform = $request->c[$i];
                $posts->page_name_id = $request->inp[$i];
                $posts->venue_id = $venue_id;
                $posts->save();
            }
            if ($request->c[$i] == 'insta') {
                $posts = new Venue_Social_Post();
                $posts->platform = $request->c[$i];
                $posts->page_name_id = $request->inp[$i];
                $posts->venue_id = $venue_id;
                $posts->save();
            }
            if ($request->c[$i] == 'twitter') {
                $posts = new Venue_Social_Post();
                $posts->platform = $request->c[$i];
                $posts->page_name_id = $request->inp[$i];
                $posts->event_id = $venue_id;
                $posts->save();
            }
            if ($request->c[$i] == 'tiktok') {
                $posts = new Venue_Social_Post();
                $posts->platform = $request->c[$i];
                $posts->page_name_id = $request->inp[$i];
                $posts->event_id = $venue_id;
                $posts->save();
            }
        }
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

    public function getPages($accestoken)
    {
        // $fb_token =Session::get('fb_token');
        $fb = new Facebook(array(
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v11.0',
        ));



        try {
            // Returns a `FacebookFacebookResponse` object
            $response = $fb->get(
                '/me/accounts',
                $accestoken
            );
        } catch (FacebookResponseException $e) {
            dd('Graph returned an error: ' . $e->getMessage());
            exit;
        } catch (FacebookSDKException $e) {
            dd('Facebook SDK returned an error: ' . $e->getMessage());
            exit;
        }
        return $response->getDecodedBody();

        // // $graphNode = $response->getDecodedBody();
        // $graphNode = $response->getGraphEdge();
        // dd($graphNode);

    }
    public function show_posts(Venue $venue)
    {

        $attach_acc = Attached_Account::where('user_id', Auth::user()->id)->where('verified_acc', 'facebook')->first();
        $accesstoken = $attach_acc->token;
        $venue_post = Venue_Social_Post::where('venue_id', $venue->id)->first();
        $data = $this->getPost($accesstoken, $venue_post->page_id);
        $this->page_data = $data['data'];
        $posts = $data['data'];
        $event = $venue;
        return view('users.content.social-wall', compact('posts', 'event'));
    }
    public function getPost($accesstoken, $page_id)
    {

        // $fb_token =Session::get('fb_token');
        $fb = new Facebook(array(
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v11.0',
        ));



        try {
            // Returns a `FacebookFacebookResponse` object
            $response = $fb->get(
                $page_id . '/posts?fields=message,shares,permalink_url,full_picture,created_time',
                $accesstoken
            );
        } catch (FacebookResponseException $e) {
            dd('Graph returned an error: ' . $e->getMessage());
            exit;
        } catch (FacebookSDKException $e) {
            dd('Facebook SDK returned an error: ' . $e->getMessage());
            exit;
        }
        return $response->getDecodedBody();

        // // $graphNode = $response->getDecodedBody();
        // $graphNode = $response->getGraphEdge();
        // dd($graphNode);

    }
}
