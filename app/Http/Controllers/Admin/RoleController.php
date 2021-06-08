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
       
       return view('admin.content.allroles');
   }
    public function roles()
   {
       return view('admin.content.addroles');
   }
   public function all_roles(Request $request)
   {
    if ($request->ajax()) {
        $data = Role::select('id','name','description');
        
        return Datatables::of($data)
                ->addColumn('action', function($row){

                       $btn = '
                       <a href="'.route('edit.roles',$row).'" class="edit btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil" ></i></a>
                       <a href="'.route('delete.roles',$row).'" onclick="return confirm(\'Do you really want to delete the role\');" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></a>
                       ';


                        return $btn;
                })
                ->make();
    }


   }
   public function delete_role($id)
   { 
    $del=Role::find($id);
    $del->delete();
    return back();
       
   }
   public function update_role(Request $request)
   {
    Role::where('id', $request->id)->update(['key' => $request->keys,"content"=>$request->quote]);
    return back();
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
        $user=User::find($id);
        return view('admin.content.assignpermissionform',compact('permissions','id','user'));
    }
    public function assign_permission(Request $request)
    {
        $id=$request->id;
       $user=User::find($id);
       $user->attachPermission($request->permission);
       return back();
    }
    public function edit_role(Request $request, Role $role){
        return view('admin/content/editrole',compact('role'));
    }
    public function updaterole(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'display'=>'required',
    
        ]);
        
        Role::where('id', $request->id)->update(['name' => $request->name,"display_name"=>$request->display,"description"=>$request->description]);
        return redirect()->route('all.roles');

        

    }
}
