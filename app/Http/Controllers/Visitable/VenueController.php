<?php

namespace App\Http\Controllers\Visitable;


use App\Http\Controllers\Controller;
use App\Models\User\Venue;
use App\Models\Venues;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Location;



class VenueController extends Controller
{
    //

    public function venue()
    {
        $venues = Venue::all()->take(3);

         /**
         * 
         * Check if more records exits
         * 
         */

        $load_more = Venue::count()>3;

        return view('users.content.venues', compact('venues','load_more'));
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

        $load_more = (count($venues)>0)?true:false;
        
        return view('users.content.venues', compact('venues', 'load_more'));
    }

    

    
}
