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

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('id', 'name', 'email', 'image')->whereRoleIs('user');

            return Datatables::of($data)
                ->addColumn('action', function ($row) {

                    $btn = '<a href="' . route('usersprofile.view', $row) . '" class="btn btn-primary btn-sm" title="View"><i class="bi bi-eye"></i></a>
                        <a href="' . route('assign.role', $row) . '" class="btn btn-success btn-sm" title="Role"><i class="bi  bi-bootstrap-reboot"></i></a>
                        ';


                    return $btn;
                })
                ->make();
        }
    }
}
