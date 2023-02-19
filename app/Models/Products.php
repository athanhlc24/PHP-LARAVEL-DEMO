<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory;
    use SoftDeletes;
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
    public function Category(){
        return $this->belongsTo(Category::class);
    }
    public function Orders(){
        return $this->belongsToMany(Order::class,"order_products");
    }
    public function scopeSearch($query,$search){
        if ($search && $search !=0){
            return $query->where("name","like","%$search%")
                ->orWhere("description","like","%$search%");
        }
        return $query;
    }
    public function scopeCategoryFilter($query,$category_id){
        if ($category_id && $category_id !=0){
            return $query->where("name","like","%$category_id%");
        }
        return $query;
    }
}
