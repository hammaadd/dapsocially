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
        $load_more = Event::count() > 8;

        return view('users.content.events', compact('events', 'load_more'));
    }


    public function show_posts(Event $event)
    {

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


    public function search_event(Request $request)
    {


        $events = [];
        $locations = [];

        if (!is_null($request->keyword) && !is_null($request->location)) {
            $events = Event::where('hashtag', '=', $request->keyword)->where('location', '=', $request->location)->get();
        } elseif (is_null($request->keyword) && !is_null($request->location)) {
            $events = Event::where('location', '=', $request->location)->get();
        }
        if (!is_null($request->keyword)) {
            $events = Event::where('hashtag', '=', $request->keyword)->get();
        }

        $load_more = (count($events)>0)?true:false;

        return view('users.content.events', compact('events','load_more'));
    }

}
