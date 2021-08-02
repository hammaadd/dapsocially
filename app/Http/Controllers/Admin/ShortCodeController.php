<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shortcode;
use Laravel\Ui\Presets\React;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Session;
class ShortCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function shortcode(){
        $data=Shortcode::all();
        return view('admin.content.shortcode',compact("data"));
    }
    public function addcode(Request $request){
        $validated = $request->validate([
            'quote' => 'required',
            'key' => 'required|unique:shortcodes',
        ]);
        
    
        $key = str_replace(' ', '', $request->key);
        $key=str_replace(' ', '-', $key);
        $key=preg_replace('/[^A-Za-z0-9\-]/', '', $key);
        $table=new Shortcode;
        $table->key=$key;
        $table->content=$request->quote;
        $table->save();
        Session::flash('message', 'Added succesfully');
        return back();
    
       
        
      
    }
    public function editcode(Request $request, Shortcode $shortQ){
        return view('admin/content/editshortcode',compact('shortQ'));
    }
    public function updatecode(Request $request){
        
        Shortcode::where('id', $request->id)->update(['key' => $request->keys,"content"=>$request->quote]);
        Session::flash('message', 'Updated succesfully');
        return back();

        

    }
    public function deletecode($id){
        $del=Shortcode::find($id);
        $del->delete();
        Session::flash('error', 'Deleted succesfully');
        return back();
    }
    public function get_shortcode(Request $request)
    {
        if ($request->ajax()) {
            $data = Shortcode::select('id','key','content');
            
            return Datatables::of($data)
                    ->addColumn('action', function($row){
    
                           $btn = '<a href="'.route('edit.code',$row).'" class="edit btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil" ></i></a>
                            <a href="'.route('delete.code',$row).'" onclick="return confirm(\'Do you really want to delete the shortcode\');" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></a>
                            ';
    
    
                            return $btn;
                    })
                    ->make();
        }
        
    }
    public function list_shortcode()
    {
     return view('admin.content.listshortcode');
    }
}
