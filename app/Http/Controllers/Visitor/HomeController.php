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
use App\Models\Venues;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('created_at','DESC')->take(6)->get();
        $venues = Venue::orderBy('created_at','DESC')->take(3)->get();
        
        /**
         * Check for Load More Buttons
         */
        $load_more_venues = Venue::count()>3;
        $load_more_events = Event::count()>6;
        
        $venuecontent = Content::where('key', 'venues')->first();
        $eventcontent = Content::where('key', 'events')->first();
        $platform = Content::where('key', 'platforms')->first();

        $contents = [
            'venuec' => $venuecontent,
            'eventc' => $eventcontent,
            'platform' => $platform,

        ];
      

        return view('visitor.content.main', compact('events', 'venues', 'load_more_events','load_more_venues', 'contents'));
    }
    
    public function about_us()
    {
        $about_us = Content::where('key', 'aboutus')->first();
        return view('visitor.content.aboutus', compact('about_us'));
    }

    public function terms_of_services()
    {
        $terms = Content::where('key', 'termsofservices')->first();
        return view('visitor.content.terms', compact('terms'));
    }

    public function privacy_policy()
    {
        $policy = Content::where('key', 'privacypolicy')->first();
        return view('visitor.content.privacy', compact('policy'));
    }

    public function report_abuse()
    {
        $abuse = Content::where('key', 'reportabuse')->first();
        return view('visitor.content.abuse', compact('abuse'));
    }

    public function contact_support()
    {
        $support = Content::where('key', 'contactsupport')->first();
        return view('visitor.content.support', compact('support'));
    }

    public function help_center()
    {
        $help = Content::where('key', 'helpcenter')->first();
        return view('visitor.content.help', compact('help'));
    }

    public function our_work()
    {
        $work = Content::where('key', 'ourwork')->first();
        return view('visitor.content.work', compact('work'));
    }

    public function features()
    {
        $features = Content::where('key', 'features')->first();
        return view('visitor.content.features', compact('features'));
    }

    public function pricing()
    {
        $P_plans = Payment_Plans::all();

        return view('visitor.content.pricing', compact('P_plans'));
    }

    public function search(Request $request)
    {

        $venues = [];
        $events = [];
        $locations = [];

        if (!is_null($request->keyword) && !is_null($request->location)) {
            $events = Event::where('hashtag', '=', $request->keyword)->where('location', '=', $request->location)->get();
            $locations = Location::where('address', '=', $request->location)->get();

            foreach ($locations as $location) {
                if (!is_null(Venue::where('location_id', '=', $location->id)->where('hashtag', '=', $request->keyword)->first())) {
                    $venues = Arr::add($venues, $location->id, Venue::where('location_id', '=', $location->id)->where('hashtag', '=', $request->keyword)->first());
                }
            }
        } elseif (is_null($request->keyword) && !is_null($request->location)) {
            $events = Event::where('location', '=', $request->location)->get();
            $locations = Location::where('address', '=', $request->location)->get();

            foreach ($locations as $location) {



                if (!is_null(Venue::where('location_id', '=', $location->id)->first())) {
                    $venues = Arr::add($venues, $location->id, Venue::where('location_id', '=', $location->id)->first());
                }
            }
        }

        $locations = Location::all();
        $loc = [];
        foreach ($locations as $location) {
            if (Arr::has($loc, $location->address)) {
            } else {
                $loc = Arr::add($loc, $location->address, $location->address);
            }
        }
        $venuecontent = Content::where('key', 'venues')->first();
        $eventcontent = Content::where('key', 'events')->first();
        $platform = Content::where('key', 'platforms')->first();

        $contents = [
            'venuec' => $venuecontent,
            'eventc' => $eventcontent,
            'platform' => $platform,

        ];
        $locations = $loc;
        $locationss = Location::all();
        $loc = [];
        foreach ($locationss as $location) {
            if (Arr::has($loc, $location->city)) {
            } else {
                $loc = Arr::add($loc, $location->city, $location->city);
            }
        }

        $load_more_venues = false;

        return view('visitor.content.main', compact('events', 'venues', 'locations', 'contents', 'loc','load_more_venues'));
    }
}
