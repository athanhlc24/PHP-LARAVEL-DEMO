<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = "products";
    //protected $primaryKey = "id";//neu la id thi k can phai noi

    protected $fillable =[
        "name",
        "price",
        "thumbnail",
        "description",
        "qty",
        "status",
        "category_id",
    ];
}
