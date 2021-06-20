<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event_Social_Post;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Models\User\Event;
use App\Models\Location;
use App\Models\EventImages;
use App\Models\User\Collect_Event_Htag;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    public function index()
    {
        $locations = Location::all();
        if (Auth::check()) {
            return view('users.content.add-event', compact('locations'));
        } else {
            return redirect()->route('signin');
        }
    }
    public function events()
    {
        if (Auth::check()) {
            $events = Event::all()->take(8);
            $locations = Location::all();
            return view('users.content.events', compact('events', 'locations'));
        } else {
            return redirect()->route('signin');
        }
    }
    public function add_event(Request $request)
    {

        $request->validate([
            'ename' => 'required',
            'e_descrip' => 'required|max:1000',
            'cover_img' => 'required',

            'location' => 'required',

            'h_tag' => 'required',
            'm_dap_wall' => 'required',
            'wall_bg_img' => 'required',
            's_date' => 'required',
            's_time' => 'required',
            'e_date' => 'required',
            'e_time' => 'required',
            'h_tags' => 'required|min:1',
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

        foreach ($request->h_tags as $h_tag) {
            $hashtag = new Collect_Event_Htag();
            $hashtag->account_name = $h_tag;
            $hashtag->event_id = $event->id;
            $hashtag->save();
        }
        Session::flash('message', 'Event added succesfully succesfully');
        return back();
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
        $locations = Location::all();
        return view('users.content.events', compact('events', 'locations'));

    }
    public function load_more_events()
    {

        $events = Event::all();
        $locations = Location::all();
        return view('users.content.events', compact('events', 'locations'));
    }
    public function my_events()
    {
        $locations = Location::all();
        $events = Event::where('created_by', '=', Auth::user()->id)->take(10)->get();
        return view('users.content.myevents',compact('locations','events'));
    }
    public function load_my_events()
    {
        $events = Event::where('created_by', '=', Auth::user()->id)->get();
        $locations = Location::all();
        return view('users.content.myevents', compact('events', 'locations'));
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
        return view('users.content.myevents', compact('events', 'locations'));
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

        $del->delete();
        if(!is_null(Event_Social_Post::find($event->social_posts))){
        $del=Event_Social_Post::find($event->social_posts);
        $del->delete();
        }
        return back();
    }

    public function edit_event(Event $event)
    {

        $locations=Location::all();
        $event_htags=Collect_Event_Htag::where('event_id', '=', $event->id)->get();

        return view('users.content.editevents',compact('event','event_htags','locations'));


    }
    public function update_event(Request $request, Event $event)
    {

        $request->validate([
            'ename' => 'required',
            'e_descrip' => 'required',

            // 'country' => 'required',
            'location'=>'required',
            // 'locality'=>'required',
            // 'state'=>'required',
            'h_tag'=>'required',
           'm_dap_wall'=>'required',

           's_date'=>'required',
           's_time'=>'required',
           'e_date'=>'required',

           'e_date'=>'required',

           'h_tags'=>'required|min:1',
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
            // if(!is_null($request->longitude && $request->latitude))
            // {

            //     Location::where('id',$event->location_id)->update(['country'=>$request->country,'state'=>$request->state,'city'=>$request->locality,'address'=>$request->loc_address,'lng'=>$request->longitude,'lat'=>$request->latitude]);
            // }
            // else{
            //     Location::where('id',$event->location_id)->update(['country'=>$request->country,'state'=>$request->state,'city'=>$request->locality,'address'=>$request->loc_address]);
            // }

            $vTags=Collect_Event_Htag::where('event_id',$event->social_posts)->get();
            foreach($vTags as $vTag){
                $vTag->delete();

            }
            foreach($request->h_tags as $h_tag){
                $hashtag=new Collect_Event_Htag();
               $hashtag->account_name=$h_tag;
               $hashtag->event_id=$event->id;
               $hashtag->save();

            }
            Event::where('id',$event->id)->update(['event_name'=>$request->ename,'e_description'=>$request->e_descrip,'hashtag'=>$request->h_tag,'approve_htag'=>$request->app_htag,
            'start_time'=>$request->s_time,'start_date'=>$request->s_date,'end_time'=>$request->e_time,'end_date'=>$request->e_date,'created_by'=>Auth::user()->id,'location'=>$request->location]);


            return redirect()->route('my.venues');



    }
}
