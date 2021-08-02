<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class LogOutController extends Controller
{
    public function index($id)
    {
        $user=User::find($id);
        if ($user->hasRole('superadministrator')) {
            return redirect()->route('admin.login');
        } elseif ($user->hasRole('user') && $user->isactive==1) {
            return redirect()->route('signin');
        }
    }
}
