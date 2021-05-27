<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Yajra\Datatables\Datatables;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('admin/content/dashboard');
        
    }
    
public function getUsers(Request $request){
    if ($request->ajax()) {
        $data = User::select('id','name','email','image')->whereRoleIs('user');
        
        return Datatables::of($data)
                ->addColumn('action', function($row){

                       $btn = '<a href="'.route('users.get',$row).'" class="edit btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil" ></i></a>
                        <a href="'.route('users.get',$row).'" onclick="return confirm(\'Do you really want to delete the customer\');" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></a>
                        <a href="'.route('usersprofile.view',$row).'" class="btn btn-primary btn-sm" title="View"><i class="bi bi-eye"></i></a>
                        <a href="'.route('assign.role',$row).'" class="btn btn-success btn-sm" title="Role"><i class="bi  bi-bootstrap-reboot"></i></a>
                        <a href="'.route('assignpermission.form',$row).'" class="btn btn-info btn-sm" title="Permission"><i class="bi  bi-pencil-square"></i></a>';


                        return $btn;
                })
                ->make();
    }
     



}
    
}
