<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contactus;
use Yajra\Datatables\Datatables;

class ContactUsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('admin.content.contactusform');
    }
    public function add_Message(Request $request)
    {
        $validated = $request->validate([
            'fname' => 'required',
            'mail' => 'required',
            'contact' => 'required',
            'message' => 'required',
            ]);
            $table=new Contactus();
        $table->name=$request->fname;
        $table->email=$request->mail;
        $table->phone=$request->contact;
        $table->message=$request->message;
        $table->save();

        return back();

       
    }
    public function show_Contactus_list()
    {
        return view('admin.content.contactuslist');
    }
    public function get_contactus_list(Request $request)
    {
        if ($request->ajax()) {
            $data = Contactus::select('id','name','email','message');
            
            return Datatables::of($data)->addColumn('action', function($row){

                $btn = '
                <a href="'.route('delete.messages',$row).'" onclick="return confirm(\'Do you really want to delete the content\');" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></a>
                    
                 ';


                 return $btn;
         })
                    ->make();
                }
        
    }
    public function delete_messages($id)
    {
        $del=Contactus::find($id);
        $del->delete();
        return back();
    }
}
