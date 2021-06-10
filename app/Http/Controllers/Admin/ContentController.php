<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Session;

class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   public function index()
   {
      return view('admin.content.content');
   }
   public function add_content(Request $request)
   {
    
    $validated = $request->validate([
       
        'key' => 'required',
        'heading' => 'required',
        'content' => 'required',
        
        ]);
        $table=new Content();
        $table->key=$request->key;
        $table->heading=$request->heading;
        $table->content=$request->content;
        $table->save();
        Session::flash('message', 'Added suucessfully!');
        return back();

   }
   public function get_contents(Request $request)
   {
    
    if ($request->ajax()) {
        $data = Content::select('id','key','heading','content');
        
        return Datatables::of($data)
                ->addColumn('action', function($row){

                       $btn = '<a href="'.route('edit.content',$row).'" class="edit btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil" ></i></a>
                       <a href="'.route('delete.content',$row).'" onclick="return confirm(\'Do you really want to delete the content\');" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></a>
                           
                        ';


                        return $btn;
                })
                ->make();
    }
   }
   public function show_content()
   {
    return view('admin.content.contentlist');
   }
   public function content_edit($id)
   {
       $Content=Content::find($id);
       return view('admin.content.contentedit',compact('Content'));
   }
    public function update_content(Request $request)
    {
        Content::where('id', $request->id)->update(['key' => $request->heading,"content"=>$request->content]);
        Session::flash('message', 'Updated suucessfully!');
        return back();
        
    }
    public function delete_content($id)
    {
        $del=Content::find($id);
        $del->delete();
        Session::flash('error', 'Deleted suucessfully!');
        return back();
    }

}
