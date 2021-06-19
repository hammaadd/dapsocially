<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\User\Venue;
use App\Models\User\Collect_Venue_Htag;
use App\Models\Venue_Social_Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Arr;
class VenueController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('users.content.add-venue');
            }else{
                return redirect()->route('signin');
            }
    }
    public function add_venue(Request $request)
    {
        $request->validate([
            'vname' => 'required',
            'e_descrip' => 'required',
            'cover_img' => 'required',
            'country' => 'required',
            'loc_address'=>'required',
            'locality'=>'required',
            'state'=>'required',
            'h_tag'=>'required',
           'm_dap_wall'=>'required',
           'wall_bg_img'=>'required',
           's_date'=>'required',
           's_time'=>'required',
           'e_date'=>'required',
           'e_time'=>'required',
           'h_tags'=>'required|min:1',
        //    'c_posts'=>'sometimes',
        //    'p_fb'=>'required_with:c_posts,on'
            ]);


            $location=new Location();
            $location->country=$request->country;
            $location->state=$request->state;
            $location->city=$request->locality;
            $location->address=$request->loc_address;
            $location->lng=$request->longitude;
            $location->lat=$request->latitude;
            $location->save();
            $venue=new Venue();
            $venue->venue_name=$request->vname;
            $venue->location_id=$location->id;
            if ($request->hasFile('cover_img')) {
                $coverImagename=$request->file('cover_img');
                $coverImagename=str_replace(' ','',time().'-'.$coverImagename->getClientOriginalName());

                $request->cover_img->move(public_path("Users/VenueImages"),$coverImagename);

                $venue->c_image=$coverImagename;

            }
            if ($request->hasFile('wall_bg_img')) {
                $bgImagename=$request->file('wall_bg_img');
                $bgImagename=str_replace(' ','',time().'-'.$bgImagename->getClientOriginalName());

                $request->wall_bg_img->move(public_path("Users/VenueImages"),$bgImagename);

                $venue->wall_bg_image=$bgImagename;

            }


            $venue->v_description=$request->e_descrip;
            $venue->hashtag=$request->h_tag;
            $venue->approve_htag=$request->app_htag;
            $venue->wall_location_msg=$request->m_dap_wall;
            $venue->start_date=$request->s_date;
            $venue->start_time=$request->s_time;
            $venue->end_date=$request->e_date;
            $venue->end_time=$request->e_time;
            $venue->created_by=Auth::user()->id;
            $venue->save();

            foreach($request->h_tags as $h_tag){
                $hashtag=new Collect_Venue_Htag();
               $hashtag->account_name=$h_tag;
               $hashtag->venue_id=$venue->id;
               $hashtag->save();

            }
            Session::flash('message', 'Venue added succesfully succesfully');
            return back();
    }
    public function Venue()
    {
        if (Auth::check()) {
            $venues=Venue::all()->take(10);
            $locations=Location::all();
            return view('users.content.venues',compact('venues','locations'));
            }
            else{
                return redirect()->route('signin');
            }
    }
    public function load_more_venues()
    {
        $venues=Venue::all();
        $locations=Location::all();
        return view('users.content.venues',compact('venues','locations'));
    }
    public function search_Venue(Request $request)
    {

        $venues=[];
        $events=[];
        $locations=[];

        if(!is_null($request->keyword) && !is_null($request->location)){

        $locations=Location::where('address','=',$request->location)->get();

        foreach($locations as $location){
            if(!is_null(Venue::where('location_id','=',$location->id)->where('hashtag','=',$request->keyword)->first())){
            $venues=Arr::add($venues,$location->id,Venue::where('location_id','=',$location->id)->where('hashtag','=',$request->keyword)->first());
            }
        }



    }
    elseif(is_null($request->keyword) && !is_null($request->location) && !is_null($request->city)){

        $locations=Location::where('address','=',$request->location)->get();

        foreach($locations as $location){



            if(!is_null(Venue::where('location_id','=',$location->id)->first())){
            $venues=Arr::add($venues,$location->id,Venue::where('location_id','=',$location->id)->first());
            }
        }

    }
        $locations=Location::all();
        return view('users.content.venues',compact('venues','locations'));

    }
public function my_venues()
{
        $locations = Location::all();
        $venues = Venue::where('created_by', '=', Auth::user()->id)->take(10)->get();
        return view('users.content.myvenues',compact('locations','venues'));
}
public function load_my_venues()
    {
        $venues = Venue::where('created_by', '=', Auth::user()->id)->get();
        $locations = Location::all();
        return view('users.content.myvenues', compact('venues', 'locations'));
    }
    public function delete_myvenue(Venue $venue)
    {
        $del=Venue::find($venue->id);
        if(!is_null(public_path('Users/VenueImages/'.$venue->c_image))){
            File::delete(public_path('Users/VenueImages/'.$venue->c_image));
        }
        if(!is_null(public_path('Users/VenueImages/'.$venue->wall_bg_image))){
            File::delete(public_path('Users/VenueImages/'.$venue->wall_bg_image));
        }

        $del->delete();
        if(!is_null(Venue_Social_Post::find($venue->social_posts))){
        $del=Venue_Social_Post::find($venue->social_posts);
        $del->delete();
        }
        return back();
    }
    public function edit_vanue(Venue $venue)
    {

        $location=Location::where('id', '=', $venue->location_id)->first();
        return view('users.content.editvenue',compact('venue','location'));


    }

}
