<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Models\Event;
use App\Models\Location;
use App\Models\EventImages;
class EventController extends Controller
{
    public function index()
    {
        $locations=Location::all();
        return view('user.content.event',compact('locations'));
    }
    public function add_event(Request $request)
    {
        
        $validated = $request->validate([
            'vname' => 'required',
            'description' => 'required',
            'image' => 'required',
            'address'=>'required',
            'hashtags'=>'required',
            ]);
            
            $event=new Event();
            $event->address=$request->address;
            $event->venue_name=$request->vname;
            $event->description=$request->description;
            $event->date_time=$request->POST['date_time']; 
            $event->hashtag=$request->hashtags; 
            $event->save();
            $Eimg=new EventImages();
               
            if ($request->hasFile('images')) {
                $newImagename=$request->file('images');
                foreach($newImagename as $image) {
                
                $newImagename=str_replace(' ','',time().'-'.$newImagename->getClientOriginalName());
                
                $request->image->move(public_path("user/VenueImages"),$newImagename);
            
                $Eimg->images=$newImagename;
                $Eimg->event_id=$event->id;
                $Eimg->save();
                }
            }
            else{
                $event->image='bn';
            }  
            
            return back();
    }

}
