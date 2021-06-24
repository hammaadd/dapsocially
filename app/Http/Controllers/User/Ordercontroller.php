<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order as ModelsOrder;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Payments;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrdersNotifications;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use SquareConnect\Model\Order as ModelOrder;

class Ordercontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('user.content.packages');
    }
    public function order_details($amount)
    {
        return view('user.content.order',compact('amount'));
    }
    public function place_order(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'email' => 'required',
            'contact' => 'required',


            ]);
            $table=new Order();
            $table->order_type='event';
            $table->order_status='pending';
            $table->event_id=null;
            $table->user_id=Auth::user()->id;
            $table->total_payment=$request->amount;
            $table->account_type=$request->package;
            $table->save();
            $user =User::whereHas(
                'roles', function($q){
                    $q->where('name', 'superadministrator');
                }
            )->get();

            $details = [
                'greeting' => 'Hi '.Auth::user()->name,
                'body' => 'A new Order is placed by user named '.Auth::user()->name.' ',
                'thanks' => 'Thank you ',
            ];
            Notification::send($user, new OrdersNotifications($details));
            //$user->notify(new OrdersNotifications($details));


            return redirect()->route('check.out',['id'=>$table->id, 'total_payment'=>$table->total_payment]);
        }
        public function check_out($id,$total_payment)
        {
         $data=['id'=>$id,'total_payment'=>$total_payment];
         return view('user.content.checkout',compact('data'));
        }
        public function payment_process($id,$total_payment)
        {

            $table=new Payments();
            $table->account_type='event';
            $table->payment=$total_payment;
            $table->user_id=Auth::user()->id;
            $table->order_id=$id;
            $table->save();
            Order::where('id', $id)->update(['order_status' => 'Paid']);
            return redirect()->route('payment.details');

        }
}
