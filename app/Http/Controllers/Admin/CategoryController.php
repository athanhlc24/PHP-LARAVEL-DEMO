<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use http\Env\Request;

class CategoryController extends Controller
{
    public function listAll(){
        $data = Category::orderBy("id","desc")->paginate(20);
        return view("admin.category.list",[
           "data"=>$data
        ]);
    }
    public function create(){
        $categories = Category::all();
        return view("admin.category.create",compact("categories"));
    }
    public function store(Request $request){
        $data = $request->all();
        Category::create($data);
        return redirect()->to("admin/category");
    }
}
