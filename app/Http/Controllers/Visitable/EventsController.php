<?php

namespace App\Http\Controllers\Visitable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\E_social_wall;

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
         * Check if more records exits
         * 
         */
        $load_more = Event::count() > 8;
        
        return view('users.content.events', compact('events', 'load_more'));
    }


    public function show_posts(Event $event)
    {
        
        /**
         * 
         * Viewing a single event
         * 
         */

        $posts = E_social_wall::where('event_id', $event->id)->get();

        return view('users.content.social-wall', compact('posts', 'event'));
    }


    public function show_venue(Event $event)
    {

         /**
         * 
         * Viewing a single venue
         * 
         */

        $posts = E_social_wall::where('event_id', $event->id)->get();



        return view('users.content.social-wall', compact('posts', 'event'));
    }

}
