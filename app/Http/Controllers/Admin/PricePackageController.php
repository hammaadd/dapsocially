<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment_Plans;
use Yajra\Datatables\Datatables;
use Facade\Ignition\Support\Packagist\Package;

class PricePackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   public function index()
   {
       return view('admin/content/pricepackage');
   }
   public function add_Package(Request $request)
   {
    $validated = $request->validate([
        'pname' => 'required',
        'descrip' => 'required',
        'price'=>'required',
        'timep'=>'required',

    ]);
    $table=new Payment_Plans();
    $table->name=$request->pname;
    $table->description=$request->descrip;
    $table->price=$request->price;
    $table->t_period=$request->timep;
    $table->save();
    return back();
   }
   
public function all_payment_plans()
{
    return view('admin.content.allpaymentplans');
}

public function list_payment_plans(Request $request)
{
    if ($request->ajax()) {
        $data = Payment_Plans::select('id','name','description','price');
        
        return Datatables::of($data)
                ->addColumn('action', function($row){

                       $btn = '
                       <a href="'.route('edit.paymentplans',$row).'" class="edit btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil" ></i></a>
                       <a href="'.route('delete.packages',$row).'" onclick="return confirm(\'Do you really want to delete the package\');" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></a>
                       ';


                        return $btn;
                })
                ->make();
}
}
public function delete_package($id)
{
    $del=Payment_Plans::find($id);
    $del->delete();
    return back();
}
public function update_paymentplans(Request $request){
        
    Payment_Plans::where('id', $request->id)->update(['name' => $request->pname,"description"=>$request->descrip,"price"=>$request->price,"t_period"=>$request->timep]);
    return redirect()->route('all.payment_plans');

    

}
public function edit_paymentplans($id)
{
    $paymentplans=Payment_Plans::find($id);
   
    return view('admin.content.editpaymentplan',compact('paymentplans'));
}
}
