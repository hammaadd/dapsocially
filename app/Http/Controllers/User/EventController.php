<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event_Social_Post;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Models\User\Event;
use App\Models\Location;
use App\Models\EventImages;
use App\Models\Order;
use App\Models\Payment_Plans;
use App\Models\User;
use App\Models\User\Attached_Account;
use App\Models\User\Collect_Event_Htag;
use App\Notifications\OrdersNotifications;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Atymic\Twitter\Facade\Twitter;

class EventController extends Controller
{
    public $page_data=[];
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
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
        $P_plans=Payment_Plans::all();
        $attach_acc=Attached_Account::where('user_id',Auth::user()->id)->where('verified_acc','facebook')->first();

        $accestoken=$attach_acc->token;

        $data=$this->getPages($accestoken);
        $tw_data = $this->getTwUserProfile();
        dd($tw_data);
        $this->page_data=$data['data'];
        $data=$data['data'];

        return view('users.content.add-event', compact('locations','P_plans','data'));

    }
    public function events()
    {

            $events = Event::all()->take(8);
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
        $locationss=Location::all();
        $loc=[];
        foreach($locationss as $location ){
            if (Arr::has($loc,$location->city)) {

               }
               else{
                $loc=Arr::add($loc,$location->city,$location->city);

               }
        }
            return view('users.content.events', compact('events', 'locations','loc'));

    }
    public function add_event(Request $request)
    {

        $request->validate([
            'ename' => 'required',
            'e_descrip' => 'required|max:1000',
            'cover_img' => 'required',
            'plan'=>'required',
            'location' => 'required',
            'c' => 'required',
            'h_tag' => 'required',
            'm_dap_wall' => 'required',
            'wall_bg_img' => 'required',
            's_date' => 'required',
            's_time' => 'required',
            'e_date' => 'required',
            'e_time' => 'required',
            'fb_page'=>'required',
            // 'fb' => 'required|min:1',
            // 'c_posts.*'=>'required|min1'
            //    'c_posts'=>'sometimes',
            //    'p_fb'=>'required_with:c_posts,on'
        ]);




        $event = new Event();
        $event->event_name = $request->ename;
        $event->location = $request->location;
        if ($request->hasFile('cover_img')) {
            $coverImagename = $request->file('cover_img');
            $coverImagename = str_replace(' ', '', time() . '-' . $coverImagename->getClientOriginalName());

            $request->cover_img->move(public_path("Users/EventImages"), $coverImagename);

            $event->c_image = $coverImagename;
        }
        if ($request->hasFile('wall_bg_img')) {
            $bgImagename = $request->file('wall_bg_img');
            $bgImagename = str_replace(' ', '', time() . '-' . $bgImagename->getClientOriginalName());

            $request->wall_bg_img->move(public_path("Users/EventImages"), $bgImagename);

            $event->wall_bg_image = $bgImagename;
        }


        $event->e_description = $request->e_descrip;
        $event->hashtag = $request->h_tag;
        $event->approve_htag = $request->app_htag;
        $event->wall_location_msg = $request->m_dap_wall;
        $event->start_date = $request->s_date;
        $event->start_time = $request->s_time;
        $event->end_date = $request->e_date;
        $event->end_time = $request->e_time;
        $event->created_by = Auth::user()->id;
        $event->save();
        $this->add_event_social_posts($event->id,$request);
        $p=Payment_Plans::where('id',$request->plan)->first();
        $odr=new Order();
        $odr->order_type="event";
        $odr->order_status="Pending";
        $odr->account_type=$p->name;
        $odr->event_id=$event->id;
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
            $hashtag = new Collect_Event_Htag();
            $hashtag->account_name = $h_tag;
            $hashtag->event_id = $event->id;
            $hashtag->save();
        }
        Session::flash('message', 'Event added succesfully succesfully');
        return back();
    }
    public function add_event_social_posts($event_id, Request $request)
    {
            $count=count($request->c);
            $counter=0;
            for($i=0;$i<$count;$i++){
               if($request->c[$i]=='facebook'){
                foreach($request->fb_page as $fb){
                    $posts=new Event_Social_Post();
                    $posts->platform='facebook';
                    $posts->page_name=$fb;
                    $posts->event_id=$event_id;
                    $posts->save();
                }

                $attach_acc=Attached_Account::where('user_id',Auth::user()->id)->where('verified_acc','facebook')->first();
                $accestoken=$attach_acc->token;
                $data=$this->getPages($accestoken);
                $data=$data['data'];

                foreach($data as $page){

                    Event_Social_Post::where('event_id',$event_id)->where('platform','facebook')->update(['page_id'=>$page['id']]);

                }

               }
               if($request->c[$i]=='insta'){
                $posts=new Event_Social_Post();
                $posts->platform=$request->c[$i];
                $posts->page_name=$request->inp[1];
                $posts->event_id=$event_id;
                $posts->save();
               }
               if($request->c[$i]=='twitter'){
                $posts=new Event_Social_Post();
                $posts->platform=$request->c[$i];
                $posts->page_name=$request->inp[2];
                $posts->event_id=$event_id;
                $posts->save();
               }
               if($request->c[$i]=='tiktok'){
                $posts=new Event_Social_Post();
                $posts->platform=$request->c[$i];
                $posts->page_name=$request->inp[3];
                $posts->event_id=$event_id;
                $posts->save();
               }


            }

    }
    public function filter_location(Request $request)
    {
        if($request->ajax())
        {
                $locations=Location::where('city',$request->q)->get();
                $loc=[];
                foreach($locations as $location ){
                    if (Arr::has($loc,$location->address)) {

                       }
                       else{
                        $loc=Arr::add($loc,$location->address,$location->address);

                       }
                }
                $locations=$loc;
                $data='';
                foreach($locations as $add) {
                    $data.='<option value="' . $add . '">' . $add .'</option>';
                }
            echo json_encode($data);

        }
    }
    public function search_Event(Request $request)
    {


        $venues=[];
        $events=[];
        $locations=[];

    if(!is_null($request->keyword) && !is_null($request->location)){
        $events=Event::where('hashtag','=',$request->keyword)->where('location','=',$request->location)->get();




    }
    elseif(is_null($request->keyword) && !is_null($request->location) ){
        $events=Event::where('location','=',$request->location)->get();


    }
    if(!is_null($request->keyword )){
        $events=Event::where('hashtag','=',$request->keyword)->get();


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
        $locationss=Location::all();
        $loc=[];
        foreach($locationss as $location ){
            if (Arr::has($loc,$location->city)) {

               }
               else{
                $loc=Arr::add($loc,$location->city,$location->city);

               }
        }
        return view('users.content.events', compact('events', 'locations','loc'));

    }
    public function load_more_events()
    {

        $events = Event::all();
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
        $locationss=Location::all();
        $loc=[];
        foreach($locationss as $location ){
            if (Arr::has($loc,$location->city)) {

               }
               else{
                $loc=Arr::add($loc,$location->city,$location->city);

               }
        }
        return view('users.content.events', compact('events', 'locations','loc'));
    }
    public function my_events()
    {
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
        $events = Event::where('created_by', '=', Auth::user()->id)->take(10)->get();
        $locationss=Location::all();
        $loc=[];
        foreach($locationss as $location ){
            if (Arr::has($loc,$location->city)) {

               }
               else{
                $loc=Arr::add($loc,$location->city,$location->city);

               }
        }
        return view('users.content.myevents',compact('locations','events','loc'));
    }
    public function load_my_events()
    {
        $events = Event::where('created_by', '=', Auth::user()->id)->get();
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
        $locationss=Location::all();
        $loc=[];
        foreach($locationss as $location ){
            if (Arr::has($loc,$location->city)) {

               }
               else{
                $loc=Arr::add($loc,$location->city,$location->city);

               }
        }
        return view('users.content.myevents', compact('events', 'locations','loc'));
    }
    public function search_my_Event(Request $request)
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
    $loc=[];
    foreach($locations as $location ){
        if (Arr::has($loc,$location->address)) {

           }
           else{
            $loc=Arr::add($loc,$location->address,$location->address);

           }
    }
    $locations=$loc;
    $locationss=Location::all();
        $loc=[];
        foreach($locationss as $location ){
            if (Arr::has($loc,$location->city)) {

               }
               else{
                $loc=Arr::add($loc,$location->city,$location->city);

               }
        }
        return view('users.content.myevents', compact('events', 'locations','loc'));
    }
    public function delete_myevent(Event $event)
    {
        $del=Event::find($event->id);
        if(!is_null(public_path('Users/EventImages/'.$event->c_image))){
            File::delete(public_path('Users/EventImages/'.$event->c_image));

        }
        if(!is_null(public_path('Users/EventImages/'.$event->wall_bg_image))){
            File::delete(public_path('Users/EventImages/'.$event->wall_bg_image));

        }
        $vTags=Collect_Event_Htag::where('event_id',$event->id)->get();
        if(!is_null(Collect_Event_Htag::where('event_id',$event->id)->get())){
        foreach($vTags as $vTag){
                $vTag->delete();
            }
        }

        if(!is_null(Event_Social_Post::where('event_id',$event->id)->get())){
        $dat=Event_Social_Post::where('event_id',$event->id)->get();
        foreach($dat as $dt){
            $dt->delete();
        }

        }

        $del->delete();
        Session::flash('message', 'Event deleted succesfully succesfully');
        return back();
    }

    public function edit_event(Event $event)
    {

        $locations=Location::all();
        $event_htags=Collect_Event_Htag::where('event_id', '=', $event->id)->get();
        $odr=Order::where('event_id',$event->id)->first();

        $payment_details=Payment_Plans::where('id',$odr->payment_plan_id)->first();
        $P_plans=Payment_Plans::all();
        $posts=Event_Social_Post::where('event_id',$event->id)->get();

        return view('users.content.editevents',compact('event','event_htags','locations','payment_details','P_plans','posts'));


    }
    public function update_event(Request $request, Event $event)
    {

        $request->validate([
            'ename' => 'required',
            'e_descrip' => 'required',
            'plan'=>'required',
            // 'country' => 'required',
            'location'=>'required',
            // 'locality'=>'required',
            // 'state'=>'required',
            'h_tag'=>'required',
           'm_dap_wall'=>'required',
           'c' => 'required',
           's_date'=>'required',
           's_time'=>'required',
           'e_date'=>'required',

           'e_date'=>'required',

           'h_tags'=>'required',
        //    'c_posts'=>'sometimes',
        //    'p_fb'=>'required_with:c_posts,on'
            ]);

            if ($request->hasFile('cover_img') ) {
                $coverImagename=$request->file('cover_img');
                $coverImagename=str_replace(' ','',time().'-'.$coverImagename->getClientOriginalName());
                File::delete(public_path('Users/EventImages/'.$event->c_image));

                $request->cover_img->move(public_path("Users/EventImages"),$coverImagename);

                Event::where('id',$event->id)->update(['c_image' => $coverImagename,'event_name'=>$request->ename,'e_description'=>$request->e_descrip,'hashtag'=>$request->h_tag,'approve_htag'=>$request->app_htag,
                'start_time'=>$request->s_time,'start_date'=>$request->s_date,'end_time'=>$request->e_time,'end_date'=>$request->e_date,'created_by'=>Auth::user()->id,'location'=>$request->location]);

            }
            if ($request->hasFile('wall_bg_img') ) {
                $coverImagename=$request->file('wall_bg_img');
                $coverImagename=str_replace(' ','',time().'-'.$coverImagename->getClientOriginalName());
                File::delete(public_path('venues/EventImages/'.$event->wall_bg_img));
                $request->wall_bg_img->move(public_path("Users/EventImages"),$coverImagename);

                Event::where('id',$event->id)->update(['wall_bg_image' => $coverImagename,'event_name'=>$request->ename,'e_description'=>$request->e_descrip,'hashtag'=>$request->h_tag,'approve_htag'=>$request->app_htag,
                'start_time'=>$request->s_time,'start_date'=>$request->s_date,'end_time'=>$request->e_time,'end_date'=>$request->e_date,'created_by'=>Auth::user()->id,'location'=>$request->location]);

            }
            $vTags=Collect_Event_Htag::where('event_id',$event->id)->get();

            foreach($vTags as $vTag){

                $vTag->delete();

            }
            $Posts=Event_Social_Post::where('event_id',$event->id)->get();

            foreach($Posts as $Post){

                $Post->delete();

            }
            $this->update_event_social_posts($event->id,$request);
            foreach($request->h_tags as $h_tag){
                $hashtag=new Collect_Event_Htag();
               $hashtag->account_name=$h_tag;
               $hashtag->event_id=$event->id;
               $hashtag->save();

            }
            $plans=Payment_Plans::where('id',$request->plan)->first();
            Order::where('event_id',$event->id)->update(['account_type'=>$plans->name,'payment_plan_id'=>$request->plan,'total_payment'=>$plans->price]);
            Event::where('id',$event->id)->update(['event_name'=>$request->ename,'e_description'=>$request->e_descrip,'hashtag'=>$request->h_tag,'approve_htag'=>$request->app_htag,
            'start_time'=>$request->s_time,'start_date'=>$request->s_date,'end_time'=>$request->e_time,'end_date'=>$request->e_date,'created_by'=>Auth::user()->id,'location'=>$request->location]);

            Session::flash('message', 'Event updated  succesfully');
            return back();
            // if(!is_null($request->longitude && $request->latitude))
            // {

            //     Location::where('id',$event->location_id)->update(['country'=>$request->country,'state'=>$request->state,'city'=>$request->locality,'address'=>$request->loc_address,'lng'=>$request->longitude,'lat'=>$request->latitude]);
            // }
            // else{
            //     Location::where('id',$event->location_id)->update(['country'=>$request->country,'state'=>$request->state,'city'=>$request->locality,'address'=>$request->loc_address]);
            // }




        }
        public function update_event_social_posts($event_id, Request $request)
    {
            $count=count($request->c);

            for($i=0;$i<$count;$i++){
               if($request->c[$i]=='facebook'){
                $posts=new Event_Social_Post();
                $posts->platform=$request->c[$i];
                $posts->page_name_id=$request->inp[$i];
                $posts->event_id=$event_id;
                $posts->save();
               }
               if($request->c[$i]=='insta'){
                $posts=new Event_Social_Post();
                $posts->platform=$request->c[$i];
                $posts->page_name_id=$request->inp[$i];
                $posts->event_id=$event_id;
                $posts->save();
               }
               if($request->c[$i]=='twitter'){
                $posts=new Event_Social_Post();
                $posts->platform=$request->c[$i];
                $posts->page_name_id=$request->inp[$i];
                $posts->event_id=$event_id;
                $posts->save();
               }
               if($request->c[$i]=='tiktok'){
                $posts=new Event_Social_Post();
                $posts->platform=$request->c[$i];
                $posts->page_name_id=$request->inp[$i];
                $posts->event_id=$event_id;
                $posts->save();
               }


            }

    }

    public function getTwUserProfile(){
        $user = Twitter::getUsers(['screen_name'=>Session::get('tw_screen_name')]);
        return $user;
    }
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
              '/me/accounts',$accestoken
            );


          } catch(FacebookResponseException $e) {
            dd('Graph returned an error: ' . $e->getMessage());
            exit;
          } catch(FacebookSDKException $e) {
            dd('Facebook SDK returned an error: ' . $e->getMessage());
            exit;
          }
          return $response->getDecodedBody();

          // // $graphNode = $response->getDecodedBody();
          // $graphNode = $response->getGraphEdge();
          // dd($graphNode);

    }
    public function show_posts(Event $event)
    {

        $attach_acc=Attached_Account::where('user_id',Auth::user()->id)->where('verified_acc','facebook')->first();
        $accesstoken=$attach_acc->token;
        $event_post=Event_Social_Post::where('event_id',$event->id)->first();
        $data=$this->getPost($accesstoken,$event_post->page_id);
        $this->page_data=$data['data'];
        $posts=$data['data'];

        return view('users.content.social-wall',compact('posts','event'));
    }
    public function getPost($accesstoken,$page_id)
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
              $page_id.'/posts?fields=message,shares,permalink_url,full_picture,created_time,from{name,username,picture}',$accesstoken
            );


          } catch(FacebookResponseException $e) {
            dd('Graph returned an error: ' . $e->getMessage());
            exit;
          } catch(FacebookSDKException $e) {
            dd('Facebook SDK returned an error: ' . $e->getMessage());
            exit;
          }
          return $response->getDecodedBody();

          // // $graphNode = $response->getDecodedBody();
          // $graphNode = $response->getGraphEdge();
          // dd($graphNode);

    }

    }
