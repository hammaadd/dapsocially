<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Order;
use App\Models\User;
use App\Models\Event_checkouts;

class OrderDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {


        return view('admin.content.orderslist',);
    }
    public function get_orders(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::select('id','order_type','order_status','total_payment', 'event_id');
            $arrData = $data->latest()->get()->toArray();
            foreach($arrData as $key => $order)
            {
                $paymentData = Event_checkouts::where('event_id', $order['event_id'])->select('payment_status')->first();
                if(isset($paymentData))
                {
                    if($paymentData->payment_status == 1)
                    {
                        $arrData[$key]['order_status'] = "Paid";
                    }

                }
            }
            //dd($arrData);

            return Datatables::of($arrData)
                    ->addColumn('action', function($row){

                           $btn = '
                           <a href="'.route('order.delete',$row).'" onclick="return confirm(\'Do you really want to delete the order\');" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></a>
                            <a href="'.route('orderusersprofile.view',$row).'" class="btn btn-primary btn-sm" title="View"><i class="bi bi-eye"></i></a>
                           ';


                            return $btn;
                    })
                    ->make();
    }
}
public function delete_order($id)
{

    $del=Order::find($id);
    $del->delete();
    return back();
}
public function profile_view($id)
{
    $order=Order::find($id);
    if($order)
    {
        $paymentData = Event_checkouts::where('event_id', $order->event_id)->select('payment_status')->first();
        if(isset($paymentData))
        {
            if($paymentData->payment_status == 1)
            {
                $order->order_status = "Paid";
            }

        }
    }
    $users=User::find($order->user_id);
    $data = [
        'order'  => $order,
        'users'   => $users,

    ];

    return view('admin.content.orderinguserprofile',compact('data'));
}

}
