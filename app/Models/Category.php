<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    //protected $primaryKey = "id";//neu la id thi k can phai noi

    protected $fillable =[
        "name",
        "image",
        "status"
    ];
    public function Products(){
        return $this->hasMany(Products::class);
    }
    public function FirstProducts(){
        return $this->hasOne(Products::class)->orderBy("price","desc");
    }
}
