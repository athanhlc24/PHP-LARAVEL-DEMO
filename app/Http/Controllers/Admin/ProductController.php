<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use Exception;
use Illuminate\Http\Request;


class ProductController extends Controller

{

    public  function listAll( Request $request){
        $search = $request->get("search");
        $categories_id = $request->get("category_id");

        $data = Products::with("Category")
            ->Search($search)
            ->CategoryFilter($categories_id)
            ->where("name","like","%$search%")
            ->orderBy("id","desc")->paginate(20);
        $categories = Category::all();
        return view("admin.product.list",[
            "data"=>$data,
            "categories"=>$categories
        ]);
    }
//    public  function listAll( Request $request){
//        $search = $request->get("search");
//
////        $data = Products::where("price",">",1)
////            ->where("qty",10)
//////            ->orWhere("status",true)
//////            ->orWhere("name","like","%a%")
//////            ->orMonth("created_at","=",3)
////            ->orderBy("id","desc")->paginate(20);
////        $data = Products::leftJoin("categories","categories.id","=","products.category_id")
////            ->select(["product.*","categories.name as category_name"])
////            ->orderBy("id","desc")->paginate(20);
//        $data = Products::with("category")->where("price",">",600)
//            ->where("qty",10)
//            ->orderBy("id","desc")->paginate(20);
//        return view("admin.product.list",[
//            "data"=>$data
//        ]);
//    }
//    public  function listAll(){
////        $data = Products::all();// tra ve doi tuong collection Product object
////        offset = (page - 1 )*limit
////        $data = Products::limit(20)->offset(20)->get();// lay 20 doi tuong va` phan trang
////        $data = Products::limit(20)->orderBy("id","desc")->get();// lay thang moi nhat
//        $data = Products::orderBy("id","desc")->paginate(20);
////        dd($data);//dump die
////        return view("admin.product.list",compact('data'));
//        return view("admin.product.list",[
//            "data"=>$data
//        ]);
//    }
    public function create(){
        $categories = Category::all();
        return view("admin.product.create",compact("categories"));
    }
    public  function store(Request $request){
        $request->validate([// rang buoc du lieu
            "name"  =>"required|string|min:6",
            "price" =>"required|numeric|min:0",
            "qty" =>"required|numeric|min:0",
            "category_id"=>"required",
            "thumbnail"=>"required|image|mimes:jpg,png,jpeg,gif"
        ],[
            "required"=>"Vui lòng nhập thông tin ",
            "string"=>"Phải nhập vào là một chuỗi văn bản",
            "min"=>"Phải nhập :attribute tối thiểu :min",
            "mimes"=>"Vui lòng nhập đúng định dạng ảnh"
        ]);
        try {
            $thumbnail = null;
            if ($request->hasFile("thumbnail")){
                $file = $request->file("thumbnail");
                $fileName = time()."-".$file->getClientOriginalName();// lay theo ten
//            $ext = $file->getClientOriginalExtension(); lay theo duoi
//            $fileName = time().".".$ext;
                $path = public_path("uploads");
                $file->move($path,$fileName);
                $thumbnail = "uploads/".$fileName;
            }

            $product =  Products::create([
                "name"=>$request->get("name"),
                "price"=>$request->get("price"),
                "thumbnail"=>$thumbnail,
                "description"=>$request->get("description"),
                "qty"=>$request->get("qty"),
                "category_id"=>$request->get("category_id"),
            ]);
            return redirect()->to("admin/product")->with("success","Thêm sản phẩm thành công");
        }catch (Exception $e){
            return redirect()->back()->with("error","Thêm dữ liệu thất bại");
        }
        }

    public function edit(Products $product){
        // dùng id để tìm product
//        $product = Products::find($id);
//        if ($product == null){
//           return abort(404);
//        }


//        $product = Product::findOrFail($id);


        $categories = Category::all();
        return view("admin.product.edit",compact("categories",'product'));

    }
    public function update(Products $product, Request $request){

        $request->validate([// rang buoc du lieu
            "name"  =>"required|string|min:6",
            "price" =>"required|numeric|min:0",
            "qty" =>"required|numeric|min:0",
            "category_id"=>"required",
            "thumbnail"=>"nullable|image|mimes:jpg,png,jpeg,gif"
        ],[
            "required"=>"Vui lòng nhập thông tin ",
            "string"=>"Phải nhập vào là một chuỗi văn bản",
            "min"=>"Phải nhập :attribute tối thiểu :min",
            "mimes"=>"Vui lòng nhập đúng định dạng ảnh"
        ]);
        $thumbnail = $product->thumbnail;
        if ($request->hasFile("thumbnail")) {
            $file = $request->file("thumbnail");
            $fileName = time() . "-" . $file->getClientOriginalName();// lay theo ten
//            $ext = $file->getClientOriginalExtension(); lay theo duoi
//            $fileName = time().".".$ext;
            $path = public_path("uploads");
            $file->move($path, $fileName);
            $thumbnail = "uploads/" . $fileName;
        }
        $product->update([
            "name"=>$request->get("name"),
            "price"=>$request->get("price"),
            "thumbnail"=>$thumbnail,
            "description"=>$request->get("description"),
            "qty"=>$request->get("qty"),
            "category_id"=>$request->get("category_id"),
        ]);
        return redirect()->to("admin/product");
    }
    public function delete(Products $product){
        $product->delete();
        return redirect()->to("admin/product");
    }

}
