<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Venue;
use Illuminate\Support\Facades\File;

class VenueController extends Controller
{
    public function index()
    {
        return view('user.content.venue');
    }
    public function add_venue(Request $request)
    {
        $validated = $request->validate([
            'vname' => 'required',
            'description' => 'required',
        
            'image' => 'required',
            'ship_address'=>'required',
            ]);
            $location=new Location();
            $location->country=$request->country;
            $location->state=$request->state;
            $location->city=$request->locality;
            $location->address=$request->ship_address;
            $location->lng=$request->longitude;
            $location->lat=$request->latitude;
            $location->save();
            $venue=new Venue();
            $venue->venue_name=$request->vname;
            $venue->description=$request->description;
            $venue->location_id=$location->id;
            if ($request->hasFile('image')) {
                $newImagename=$request->file('image');
                $newImagename=str_replace(' ','',time().'-'.$newImagename->getClientOriginalName());
                
                $request->image->move(public_path("user/LocationsImages"),$newImagename);
            
                $venue->image=$newImagename;
                
            }
            else{
                $venue->image='bn';
            }  
            $venue->save();
            return back();
    }
    

}
