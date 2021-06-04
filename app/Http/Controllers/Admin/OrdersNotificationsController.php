<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersNotificationsController extends Controller
{
    public function index($id)
    {
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        return redirect()->route('orders.list');
    }
}
