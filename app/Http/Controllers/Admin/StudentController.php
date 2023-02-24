<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentController extends Controller
{
    public function listStudent(){
        $data = Student::all();
        return view("admin.student.list",[
            "data"=>$data
        ]);

    }
    public function createStudent(){
        $create = Student::all();
        return view("admin.student.create",compact("create"));
    }
    public function save(Request $request){
        $request->validate([
            "name"=>"required|string|min:2",
            "age"=>"required|numeric|min:18|max:50",
            "address"=>"required|string|min:2",
            "telephone"=>"required|string|min:9"
        ],[
            "required"=>"Dien day du thong tin",
            "string"=>"Nhap vao dang chuoi",
            "min"=>"toi thieu :min",
            "max"=>"toi da :max"
        ]);

        try{
             Student::create([
                "name"=>$request->get("name"),
                "age"=>$request->get("age"),
                "address"=>$request->get("address"),
                "telephone"=>$request->get("telephone")
            ]);
            return redirect()->to("/admin/student/list-Student");
        }catch (Exception $e ){
            return redirect()->back();
        }

    }
}
