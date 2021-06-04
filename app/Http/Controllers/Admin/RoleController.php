<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Role;
use Yajra\Datatables\Datatables;
use App\Models\User;
use Laravel\Ui\Presets\React;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
   {
       return view('admin.content.addroles');
   }
   public function addrole(Request $request)
   {
    $validated = $request->validate([
        'rname' => 'required',
        'description' => 'required',
        'display'=>'required',

    ]);
      $table=new Role();
      $table->name=$request->rname;
      $table->display_name=$request->display;
      $table->description=$request->description;
      $table->save();
      return back();
   }
   
   public function assignrole($id)
   {
      $roles=Role::all();
      return view('admin.content.assignrole',compact('roles','id'));
   }
   public function giveroletouser(Request $request)
   {
       $id=$request->id;
       $user=User::find($id);
       $user->attachRole($request->role);
       return back();

       
   }
      
    
    public function permission_form(Request $request,$id)
    {
        $permissions=Permission::all();
        return view('admin.content.assignpermissionform',compact('permissions','id'));
    }
    public function assign_permission(Request $request)
    {
        $id=$request->id;
       $user=User::find($id);
       $user->attachPermission($request->permission);
       return back();
    }
}
