<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.content.category');
    }
    public function add_category(Request $request)
    {
        $validated = $request->validate([

        'catname' => 'required',


        ]);
        $table=new Category();
        $table->category=$request->catname;
        $table->save();
        Session::flash('message', 'Category added succesully');
        return back();




    }
    public function get_category(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::select('id','category');

            return Datatables::of($data)
                    ->addColumn('action', function($row){

                           $btn = '<a href="'.route('edit.category',$row).'" class="edit btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil" ></i></a>
                           <a href="'.route('delete.category',$row).'" onclick="return confirm(\'Do you really want to delete this category\');" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></a>

                            ';


                            return $btn;
                    })
                    ->make();
        }
    }
    public function show_category()
    {
        return view('admin.content.showcategory');
    }
    public function edit_category(Category $category)
    {
       return view('admin.content.editcategory',compact('category'));
    }
    public function update_category(Request $request)
    {
        $validated = $request->validate([

            'catname' => 'required',


            ]);

            Category::where('id', $request->id)->update(['category' => $request->catname]);
            Session::flash('message', 'Updated suucessfully!');
            return back();

    }
    public function delete_category($id)
    {
        $del=Category::find($id);
        $del->delete();
        Session::flash('error', 'Deleted suucessfully!');
        return back();
    }

}
