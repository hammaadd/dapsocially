<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use App\Models\User\Event;
use App\Models\User\Venue;
use App\Models\Location;
use App\Models\Payment_Plans;
use App\Models\Shortcode;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    public function index()
    {
        $events=Event::all()->take(6);
        $venues=Venue::all()->take(3);
        $venuecontent=Content::where('key','venues')->first();
        $eventcontent=Content::where('key','events')->first();
        $platform=Content::where('key','platforms')->first();

        $contents=[
            'venuec'=>$venuecontent,
            'eventc'=>$eventcontent,
            'platform'=>$platform,

        ];
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
        return view('visitor.content.main',compact('events','venues','locations','contents'));
    }
    public function about_us()
    {
        $about_us=Content::where('key','aboutus')->first();
        return view('visitor.content.aboutus',compact('about_us'));
    }
    public function pricing()
    {
        $P_plans=Payment_Plans::all();

        return view('visitor.content.pricing',compact('P_plans'));
    }
    public function search(Request $request)
    {

        $venues=[];
        $events=[];
        $locations=[];

        if(!is_null($request->keyword) && !is_null($request->location)){
        $events=Event::where('hashtag','=',$request->keyword)->where('location','=',$request->location)->get();
        $locations=Location::where('address','=',$request->location)->get();

        foreach($locations as $location){
            if(!is_null(Venue::where('location_id','=',$location->id)->where('hashtag','=',$request->keyword)->first())){
            $venues=Arr::add($venues,$location->id,Venue::where('location_id','=',$location->id)->where('hashtag','=',$request->keyword)->first());
            }
        }



    }
    elseif(is_null($request->keyword) && !is_null($request->location) ){
        $events=Event::where('location','=',$request->location)->get();
        $locations=Location::where('address','=',$request->location)->get();

        foreach($locations as $location){



            if(!is_null(Venue::where('location_id','=',$location->id)->first())){
            $venues=Arr::add($venues,$location->id,Venue::where('location_id','=',$location->id)->first());
            }
        }

    }
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
        return view('visitor.content.main',compact('events','venues','locations'));


    }
}
