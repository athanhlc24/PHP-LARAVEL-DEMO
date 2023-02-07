<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public  function listAll(){
//        $data = Products::all();// tra ve doi tuong collection Product object
//        offset = (page - 1 )*limit
//        $data = Products::limit(20)->offset(20)->get();// lay 20 doi tuong va` phan trang
//        $data = Products::limit(20)->orderBy("id","desc")->get();// lay thang moi nhat
        $data = Products::orderBy("id","desc")->paginate(20);
//        dd($data);//dump die
//        return view("admin.product.list",compact('data'));
        return view("admin.product.list",[
            "data"=>$data
        ]);
    }
    public function create(){
        $categories = Category::all();
        return view("admin.product.create",compact("categories"));
    }
    public  function store(Request $request){
        $data = $request->all();
        Products::create($data);
        return redirect()->to("admin/product");
    }
}
