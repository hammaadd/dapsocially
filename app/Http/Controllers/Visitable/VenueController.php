<?php

namespace App\Http\Controllers\Visitable;


use App\Http\Controllers\Controller;
use App\Models\User\Venue;
use App\Models\Venues;

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


    
}
