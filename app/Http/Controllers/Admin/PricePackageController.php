<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment_Plans;
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
}
