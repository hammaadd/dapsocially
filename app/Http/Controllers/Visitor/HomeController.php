<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Event;
use App\Models\User\Venue;
use App\Models\Location;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    public function index()
    {
        $events=Event::all()->take(6);
        $venues=Venue::all()->take(3);
        $locations=Location::all();

        return view('visitor.content.main',compact('events','venues','locations'));
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
    elseif(is_null($request->keyword) && !is_null($request->location) && !is_null($request->city)){
        $events=Event::where('location','=',$request->location)->get();
        $locations=Location::where('address','=',$request->location)->get();

        foreach($locations as $location){



            if(!is_null(Venue::where('location_id','=',$location->id)->first())){
            $venues=Arr::add($venues,$location->id,Venue::where('location_id','=',$location->id)->first());
            }
        }

    }
        $locations=Location::all();
        return view('visitor.content.main',compact('events','venues','locations'));


    }
}
