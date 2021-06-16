<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\User\Venue;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
class VenueController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('users.content.add-venue');
            }else{
                return redirect()->route('signin');
            }
    }
    public function add_venue(Request $request)
    {
        $request->validate([
            'vname' => 'required',
            'e_descrip' => 'required',
            'cover_img' => 'required',
            'country' => 'required',
            'loc_address'=>'required',
            'locality'=>'required',
            'state'=>'required',
            'h_tag'=>'required',
           'm_dap_wall'=>'required',
           'wall_bg_img'=>'required',
           's_date'=>'required',
           's_time'=>'required',
            ]);
            return back();
    }
    

}
