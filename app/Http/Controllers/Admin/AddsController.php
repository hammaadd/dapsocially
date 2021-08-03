<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Models\Adds;
use App\Models\Adds_details;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
// import the Intervention Image Manager Class
// use Intervention\Image\ImageManager as Image;;
use Image;

class AddsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('admin.content.imageadd');
    }
    public function   vidoe_add()
    {
        return view('admin.content.videoadd');
    }

    public function upload_image_add(Request $request)
    {
        $validated = $request->validate(['img' => 'required|image',]);


        $adds = new Adds();
        if ($request->has('img')) {
           try {
            $newImagename = $request->file('img');
            $newImagename = str_replace(' ', '', time() . '-' . $newImagename->getClientOriginalName());


            $request->img->move(public_path("admin/assets/adds"), $newImagename);
            # open an image file
            $img = Image::make(public_path("admin/assets/adds/$newImagename"));
            #  now resize the instance
            $img->resize(320, 240);

            // finally we save the image as a new file
            $img->save(public_path("admin/assets/adds/thumb-$newImagename"));

            DB::insert('insert into background_images(image,tag) values (?, ?)', [$newImagename, $request->title]);
            Session::flash('message', 'Ad Uploaded succesfully');
            return back();
           } catch (\Throwable $th) {
            Session::flash('error', 'Unable to upload Image !');
            return back();
           }

        }
    }
    public function upload_video_add(Request $request)
    {
        $validated = $request->validate([

            'time' => 'required',
            'title' => 'required',
            'vid' => 'required|max:500000',
            'a_type' => 'required|min:1',
            'cat' => 'required|min:1'
        ]);



        $adds = new Adds();
        if ($request->has('vid')) {
            $newVideoname = $request->file('vid');
            $newVideoname = str_replace(' ', '', time() . '-' . $newVideoname->getClientOriginalName());
            $request->vid->move(public_path("admin/assets/adds"), $newVideoname);

            $adds->add = $newVideoname;
            $adds->time = $request->time;
            $adds->add_title = $request->title;
            $adds->add_type = 'video';
            $adds->save();
            foreach ($request->cat as $cat) {
                foreach ($request->a_type as $type) {
                    $table = new Adds_details();
                    $table->category = $cat;
                    $table->account_type = $type;
                    $table->add_id = $adds->id;
                    $table->add_type = 'video';
                    $table->save();
                }
            }
            Session::flash('message', 'Ad Uploaded succesfully');
            return back();

            // if(($request->events || $request->venues) && ($request->paid || $request->free)){
            //     $adds->add=$newVideoname;
            //     $adds->add_title=$request->title;
            //     $adds->time=$request->time;
            //     $adds->add_type='video';
            //     $adds->save();

            // }
            // $table=new Adds_details();
            // if($request->events && $request->free){
            //     $table->category=$request->events;
            //    $table->account_type=$request->free;
            //    $table->add_id=$adds->id;
            //    $table->add_type='video';
            //    $table->save();
            // }
            // $table=new Adds_details();
            // if($request->venues && $request->free){
            //     $table->category=$request->venues;
            //     $table->account_type=$request->free;
            //     $table->add_id=$adds->id;
            //     $table->add_type='video';
            //     $table->save();
            // }
            // $table=new Adds_details();
            // if($request->events && $request->paid){
            //     $table->category=$request->events;
            //    $table->account_type=$request->paid;
            //    $table->add_id=$adds->id;
            //    $table->add_type='video';
            //    $table->save();
            // }
            // $table=new Adds_details();
            // if($request->venues && $request->paid){
            //     $table->category=$request->venues;
            //     $table->account_type=$request->paid;
            //     $table->add_id=$adds->id;
            //     $table->add_type='video';
            //     $table->save();
            // }
            // if(!$request->paid && !$request->free && !$request->events && !$request->venues)
            // {
            //     Session::flash('error', 'Please select one category below');
            //     return back();
            // }
            // if(!$request->paid && !$request->free )
            // {
            //     Session::flash('error', 'Please select one category below(Free/Paid)');
            //     return back();
            // }
            // if(!$request->events && !$request->venues )
            // {
            //     Session::flash('error', 'Please select one Event/Venue from the below category');
            //     return back();
            // }
            // Session::flash('message', 'Ad Uploaded succesfully');
            // return back();

        }
    }
    public function get_adds(Request $request)
    {

        if ($request->ajax()) {
            $data = Adds::select('id', 'add_title', 'add_type', 'time')->orderBy('id', 'DESC');;

            return Datatables::of($data)
                ->addColumn('action', function ($row) {

                    $btn = '<a href="' . route('edit.adds', $row) . '" class="edit btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil" ></i></a>
                        <a href="' . route('delete.adds', $row) . '" onclick="return confirm(\'Do you really want to delete this Ads\');" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></a>

                         ';


                    return $btn;
                })
                ->make();
        }
    }
    public function show_adds()
    {
        return view('admin.content.showadds');
    }
    public function edit_adds(Adds $add)
    {
        $EF = 0;
        $EP = 0;
        $VF = 0;
        $VP = 0;

        $type = $add->add_type;
        $add_details = Adds_details::where('add_id', $add->id)->get();
        foreach ($add_details as $details) {
            if ($details->category == 'Events' && $details->account_type == 'Free') {
                $EF = 1;
            } elseif ($details->category == 'Events' && $details->account_type == 'Paid') {
                $EP = 1;
            } elseif ($details->category == 'Venues' && $details->account_type == 'Free') {
                $VF = 1;
            } elseif ($details->category == 'Venues' && $details->account_type == 'Paid') {
                $VP = 1;
            }
        }
        return view('admin.content.editadd', compact('add_details', 'add', 'type', 'EF', 'VF', 'EP', 'VP'));
    }

    public function delete_id($id)
    {


        $data = Adds_details::where('add_id', $id)->get();
        foreach ($data as $dat) {
            $del = Adds_details::find($dat->id)->delete();
        }
        $del = Adds::find($id);
        $del->delete();

        Session::flash('message', 'Deleted suucessfully!');
        return back();
    }
    public function update_image_add(Request $request)
    {
        $validated = $request->validate([

            'time' => 'required',


        ]);



        $adds = new Adds();
        if ($request->has('img')) {
            $newImagename = $request->file('img');
            $newImagename = str_replace(' ', '', time() . '-' . $newImagename->getClientOriginalName());
            $request->img->move(public_path("admin/assets/adds"), $newImagename);
            File::delete(public_path('admin/assets/adds/' . $request->addpath));
            if (!$request->paid && !$request->free && !$request->events && !$request->venues) {
                Adds::where('id', $request->id)->update(['add' => $newImagename, "time" => $request->time]);
                Session::flash('message', 'Updated successfully!');
                return back();
            }
            $table = new Adds_details();


            if (($request->events || $request->venues) && ($request->paid || $request->free)) {
                $data = Adds_details::where('add_id', $request->id)->get();
                foreach ($data as $dat) {
                    $del = Adds_details::find($dat->id)->delete();
                }
            } else {
                Session::flash('error', 'Please select one category below(Free/Paid and Event/Venue)');
                return back();
            }
            if ($request->events && $request->free) {
                $table->category = $request->events;
                $table->account_type = $request->free;
                $table->add_id = $request->id;
                $table->add_type = 'image';
                $table->save();
            }
            $table = new Adds_details();
            if ($request->venues && $request->free) {
                $table->category = $request->venues;
                $table->account_type = $request->free;
                $table->add_id = $request->id;
                $table->add_type = 'image';
                $table->save();
            }
            $table = new Adds_details();
            if ($request->events && $request->paid) {
                $table->category = $request->events;
                $table->account_type = $request->paid;
                $table->add_id = $request->id;
                $table->add_type = 'image';
                $table->save();
            }
            $table = new Adds_details();
            if ($request->venues && $request->paid) {
                $table->category = $request->venues;
                $table->account_type = $request->paid;
                $table->add_id = $request->id;
                $table->add_type = 'image';
                $table->save();
            }
            Adds::where('id', $request->id)->update(['add' => $newImagename, "time" => $request->time]);
            Session::flash('message', 'Updated successfully!');
            return back();
        } else {
            if (!$request->paid && !$request->free && !$request->events && !$request->venues) {
                Adds::where('id', $request->id)->update(["time" => $request->time]);
                Session::flash('message', 'Updated successfully!');
                return back();
            }
            $table = new Adds_details();


            if (($request->events || $request->venues) && ($request->paid || $request->free)) {
                $data = Adds_details::where('add_id', $request->id)->get();
                foreach ($data as $dat) {
                    $del = Adds_details::find($dat->id)->delete();
                }
            } else {
                Session::flash('error', 'Please select one category below(Free/Paid and Event/Venue)');
                return back();
            }
            if ($request->events && $request->free) {
                $table->category = $request->events;
                $table->account_type = $request->free;
                $table->add_id = $request->id;
                $table->add_type = 'image';
                $table->save();
            }
            $table = new Adds_details();
            if ($request->venues && $request->free) {
                $table->category = $request->venues;
                $table->account_type = $request->free;
                $table->add_id = $request->id;
                $table->add_type = 'image';
                $table->save();
            }
            $table = new Adds_details();
            if ($request->events && $request->paid) {
                $table->category = $request->events;
                $table->account_type = $request->paid;
                $table->add_id = $request->id;
                $table->add_type = 'image';
                $table->save();
            }
            $table = new Adds_details();
            if ($request->venues && $request->paid) {
                $table->category = $request->venues;
                $table->account_type = $request->paid;
                $table->add_id = $request->id;
                $table->add_type = 'image';
                $table->save();
            }
            Adds::where('id', $request->id)->update(["time" => $request->time]);
            Session::flash('message', 'Updated successfully!');
            return back();
        }
    }

    public function update_video_add(Request $request)
    {
        $validated = $request->validate([

            'time' => 'required',


        ]);



        $adds = new Adds();
        if ($request->has('vid')) {
            $newVideoname = $request->file('vid');
            $newVideoname = str_replace(' ', '', time() . '-' . $newVideoname->getClientOriginalName());
            $request->vid->move(public_path("admin/assets/adds"), $newVideoname);
            File::delete(public_path('admin/assets/adds/' . $request->addpath));
            if (!$request->paid && !$request->free && !$request->events && !$request->venues) {
                Adds::where('id', $request->id)->update(['add' => $newVideoname, "time" => $request->time]);
                Session::flash('message', 'Updated successfully!');
                return back();
            }
            $table = new Adds_details();


            if (($request->events || $request->venues) && ($request->paid || $request->free)) {
                $data = Adds_details::where('add_id', $request->id)->get();
                foreach ($data as $dat) {
                    $del = Adds_details::find($dat->id)->delete();
                }
            } else {
                Session::flash('error', 'Please select one category below(Free/Paid and Event/Venue)');
                return back();
            }
            if ($request->events && $request->free) {
                $table->category = $request->events;
                $table->account_type = $request->free;
                $table->add_id = $request->id;
                $table->add_type = 'video';
                $table->save();
            }
            $table = new Adds_details();
            if ($request->venues && $request->free) {
                $table->category = $request->venues;
                $table->account_type = $request->free;
                $table->add_id = $request->id;
                $table->add_type = 'video';
                $table->save();
            }
            $table = new Adds_details();
            if ($request->events && $request->paid) {
                $table->category = $request->events;
                $table->account_type = $request->paid;
                $table->add_id = $request->id;
                $table->add_type = 'video';
                $table->save();
            }
            $table = new Adds_details();
            if ($request->venues && $request->paid) {
                $table->category = $request->venues;
                $table->account_type = $request->paid;
                $table->add_id = $request->id;
                $table->add_type = 'video';
                $table->save();
            }
            Adds::where('id', $request->id)->update(['add' => $newVideoname, "time" => $request->time]);
            Session::flash('message', 'Updated successfully!');
            return back();
        } else {
            if (!$request->paid && !$request->free && !$request->events && !$request->venues) {
                Adds::where('id', $request->id)->update(["time" => $request->time]);
                Session::flash('message', 'Updated successfully!');
                return back();
            }
            $table = new Adds_details();


            if (($request->events || $request->venues) && ($request->paid || $request->free)) {
                $data = Adds_details::where('add_id', $request->id)->get();
                foreach ($data as $dat) {
                    $del = Adds_details::find($dat->id)->delete();
                }
            } else {
                Session::flash('error', 'Please select one category below(Free/Paid and Event/Venue)');
                return back();
            }
            if ($request->events && $request->free) {
                $table->category = $request->events;
                $table->account_type = $request->free;
                $table->add_id = $request->id;
                $table->add_type = 'video';
                $table->save();
            }
            $table = new Adds_details();
            if ($request->venues && $request->free) {
                $table->category = $request->venues;
                $table->account_type = $request->free;
                $table->add_id = $request->id;
                $table->add_type = 'video';
                $table->save();
            }
            $table = new Adds_details();
            if ($request->events && $request->paid) {
                $table->category = $request->events;
                $table->account_type = $request->paid;
                $table->add_id = $request->id;
                $table->add_type = 'video';
                $table->save();
            }
            $table = new Adds_details();
            if ($request->venues && $request->paid) {
                $table->category = $request->venues;
                $table->account_type = $request->paid;
                $table->add_id = $request->id;
                $table->add_type = 'video';
                $table->save();
            }
            Adds::where('id', $request->id)->update(["time" => $request->time]);
            Session::flash('message', 'Updated successfully!');
            return back();
        }
    }
}
