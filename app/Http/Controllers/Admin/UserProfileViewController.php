<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class UserProfileViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
     public function index($id)
    {
         $user=User::find($id);
        return view('admin.content.userprofileview',compact('user'));
    }
    public function isActive($id,$status)
    {
        User::where('id',$id)->update(['isactive' => $status]);
        return back();
    }
}
