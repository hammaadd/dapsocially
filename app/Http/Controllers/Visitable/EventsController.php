<?php

namespace App\Http\Controllers\Visitable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User\Event;
use App\Models\Venues;
use Illuminate\Support\Arr;


class EventsController extends Controller
{
    //

    public function events(Request $request)
    {


        $events = Event::all()->take(8);
        
        /**
         * 
         * Location should have all the venues as drop down
         */
        $locations = [];
        $location = Venues::select('venue_name')->get();
        foreach ($location as $key => $value) {
            $locations[] = $value['venue_name'];
        }
        
        // return $loc;
        
        return view('users.content.events', compact('events', 'locations'));
    }

}
