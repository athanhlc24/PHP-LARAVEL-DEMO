<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = "students";
    //protected $primaryKey = "id";//neu la id thi k can phai noi

    protected $fillable =[
        "name",
        "age",
        "address",
        "telephone",
    ];
}
