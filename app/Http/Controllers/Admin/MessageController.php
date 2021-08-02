<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SliderMessage;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Session;
class MessageController extends Controller
{
    public function index()
    {
        return view('admin.content.message');
    }
    public function add_message(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required',
            'message' => 'required',

            ]);
        $message=new SliderMessage();
        $message->key=$request->key;
        $message->message=$request->message;
        $message->save();
        return back();

    }
    public function all_messages()
    {
        return view('admin.content.listslidermessage');
    }
     public function get_messages(Request $request)
    {
        if ($request->ajax()) {
            $data = SliderMessage::select('id','key','message');


            return Datatables::of($data)
                    ->addColumn('action', function($row){

                           $btn = '<a href="'.route('edit.messages',$row).'" class="edit btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil" ></i></a>
                            <a href="'.route('delete.messages',$row).'" onclick="return confirm(\'Do you really want to delete the Message\');" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></a>
                            ';


                            return $btn;
                    })
                    ->make();
        }
    }

    public function editmessage(Request $request, SliderMessage $message){
        return view('admin.content.editmessage',compact('message'));
    }
    public function updatemessage(Request $request){

        SliderMessage::where('id', $request->id)->update(['key' => $request->key,"message"=>$request->message]);
        Session::flash('message', 'Updated succesfully');
        return back();



    }
    public function deletemessage($id){
        $del=SliderMessage::find($id);
        $del->delete();
        Session::flash('error', 'Deleted succesfully');
        return back();
    }
}
