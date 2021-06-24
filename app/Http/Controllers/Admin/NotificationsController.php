<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\FreeuserNotifications;
use App\Notifications\OrdersNotifications;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\ElseIf_;

class NotificationsController extends Controller
{
    public function index()
    {
        return view('admin.content.sendusersnotification');
    }
    public function send_notification_to_freeuser(Request $request)
    {
        // $user =User::whereHas(
        //     'roles', function($q){
        //         $q->where('name', 'user');
        //     }
        // )->get();


        $validated = $request->validate([

            'message' => 'required',

            ]);
            $account_type="";
            $roles = $request->input('roles');
            if($roles){
                foreach($roles as $role){
                    if($role=="free"){
                        $account_type="Standard Account";

                    }
                    elseif($role=="Diamond"){
                        $account_type="Diamond";
                    }
                    else{
                        $account_type="Silver";
                    }
                    $users=User::where('account_type','=',$account_type)->whereHas(
                        'roles', function($q){
                            $q->where('name', 'user');
                        }
                    )->get();
                    foreach($users as $user){
                        $details = [
                            'greeting' => 'Hi '.$user->name,
                            'body' => 'Hello Mr/Ms '.$user->name.' '.$request->message,
                            'thanks' => 'Thank you ',
                        ];
                        Notification::send($user, new FreeuserNotifications($details));

                }


            }
            Session::flash('message', 'Notification send suucessfully!');
            return back();
        }
            else {
                Session::flash('error', 'Please select atleast one Category');
                return back();
            }



    }
}
