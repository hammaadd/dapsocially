<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\User\Attached_Account;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        $attach_accounts = Attached_Account::where('user_id', Auth::user()->id)->get();
        return view('users.content.profile', compact('attach_accounts'));
    }
    public function update_password(Request $request)
    {
        $request->validate([
            'currentpassword' => 'required',
            'newpassword' => 'required|min:8|different:password',
            'confirmpassword' => 'required|same:newpassword'
        ]);

        $old_password = $request->currentpassword;
        $new_password = $request->newpassword;
        $confirm_password = $request->confirmpassword;
        $hashedPassword = Auth::user()->password;
        $message = "";
        if (Hash::check($old_password, $hashedPassword)) {

            $new_password = Hash::make($new_password);
            User::where('id', Auth::user()->id)->update(['password' => $new_password]);
            Session::flash('message', 'Password Changed suucessfully!');
        } else {
            Session::flash('message', 'Password does not change. Cuurent password not matched');
        }

        return back();
    }
    public function update_profile(Request $request)
    {
        $validated = $request->validate([
            'uname' => 'required',
            'mail' => 'required',
            'dob' => 'required',

        ]);

        if ($request->hasFile('profile_photo')) {
            $newImagename = $request->file('profile_photo');
            $newImagename = str_replace(' ', '', time() . '-' . $newImagename->getClientOriginalName());

            $request->profile_photo->move(public_path("user/profile/"), $newImagename);
            File::delete(public_path('user/profile/' . $request->path));
            User::where('id', Auth::user()->id)->update(['name' => $request->uname, 'dob' => $request->dob, 'gender' => $request->gender, "image" => $newImagename]);
            return back();
        } else {
            User::where('id', Auth::user()->id)->update(['name' => $request->uname, 'dob' => $request->dob, 'gender' => $request->gender]);
            return back();
        }
    }
}
