<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Role;
use Yajra\Datatables\Datatables;
use App\Models\User;
use Laravel\Ui\Presets\React;
use Illuminate\Support\Facades\Session;

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
            $data = Role::select('id', 'name', 'description');

            return Datatables::of($data)
                ->addColumn('action', function ($row) {

                    $btn = '
                       <a href="' . route('edit.roles', $row) . '" class="edit btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil" ></i></a>
                       <a href="' . route('delete.roles', $row) . '" onclick="return confirm(\'Do you really want to delete the role\');" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></a>
                       <a href="'.route('role.permission',$row).'" class="btn btn-primary btn-sm" title="View"><i class="bi bi-eye"></i></a>';


                    return $btn;
                })
                ->make();
        }
    }
    public function delete_role($id)
    {
        $del = Role::find($id);
        $del->delete();
        Session::flash('error', 'Role deleted'); 
        return back();
    }
    public function update_role(Request $request)
    {
        Role::where('id', $request->id)->update(['key' => $request->keys, "content" => $request->quote]);
        Session::flash('message', 'Updated succesfully'); 
        return back();
    }
    public function addrole(Request $request)
    {
        $validated = $request->validate([
            'rname' => 'required',
            'description' => 'required',
            'display' => 'required',

        ]);
        $table = new Role();
        $table->name = $request->rname;
        $table->display_name = $request->display;
        $table->description = $request->description;
        $table->save();
        Session::flash('message', 'Added suucessfully!'); 
        return back();
    }

    public function assignrole($id)
    {
        $roles = Role::all();
         
        return view('admin.content.assignrole', compact('roles', 'id'));
    }
    public function giveroletouser(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        
        if (!($user->hasRole($request->role))) {
            $user->attachRole($request->role);
            Session::flash('message', 'Role assigned suucessfully!');
            return back();
         }else{
             Session::flash('message', 'This role is already assigned to this user!');
            return back();
       }
    }


    public function permission_form(Request $request)
    {
        $permissions = Permission::all();
        $roles=Role::all();
        
        return view('admin.content.assignpermissionform', compact('permissions', 'roles'));
    }
    public function assign_permission(Request $request)
    {
        

        
        $allpermissions = Permission::all();
        $user = Role::where('display_name', '=', $request->role)->first();
        $permissions = $request->input('permissions');

        foreach($allpermissions as $permission)
        {

            $user->detachPermission($permission);
        }
        foreach ($permissions as $permission) {
            if (!($user->hasPermission($permission))) {
                $user->attachPermission($permission);
                
            }
        }
 
        Session::flash('message', 'Permission assigned');
        return back();
    }
    public function edit_role(Request $request, Role $role)
    {
        return view('admin/content/editrole', compact('role'));
    }
    public function updaterole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'display' => 'required',

        ]);

        Role::where('id', $request->id)->update(['name' => $request->name, "display_name" => $request->display, "description" => $request->description]);
        
        return redirect()->route('all.roles');
    }
    public function view_role_permissions($id){
        $role = Role::where('id', '=', $id)->first();
        $permissions= $role->load('permissions');
        $permissions=$permissions->permissions;
        return view('admin.content.rolepermission',compact('role','permissions'));
        }
        function deassign_permission(Request $request){
            $allpermissions = Permission::all();
            $role = Role::where('display_name', '=', $request->role)->first();
            $permissions = $request->input('permissions');
    
            foreach($allpermissions as $permission)
            {
    
                $role->detachPermission($permission);
            }
            foreach ($permissions as $permission) {
                if (!($role->hasPermission($permission))) {
                    $role->attachPermission($permission);
                    
                }
            }
            Session::flash('error', 'Permission deassigned!');
            return back();
    }
}
