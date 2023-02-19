<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[App\Http\Controllers\WebController::class,"home"]);
Route::get('/about-us', [App\Http\Controllers\WebController::class,"aboutUs"]);
Route::get('/detail/{product}', [App\Http\Controllers\WebController::class,"detail"])->name("product_detail");
Route::post('/addToCart/{product}', [App\Http\Controllers\WebController::class,"addToCart"])->name("add_to_cart");
Route::get('/shopping-cart', [App\Http\Controllers\WebController::class,"cart"]);
Route::get('/checkout',[WebController::class,"checkout"]);
Route::get('/remove-cart/{product}',[WebController::class,"remove"]);

//  product
Route::middleware(["auth","admin"])->prefix("admin")->group(function (){
    Route::get("/dashboard",[HomeController::class,"index"]);

    Route::prefix("product")->group(function (){
        Route::get("/",[ProductController::class,"listAll"]);
        Route::get("/create",[ProductController::class,"create"]);
        Route::post("/create",[ProductController::class,"store"]);

        Route::get("/edit/{product}",[ProductController::class,"edit"]);
        Route::post("/edit/{product}",[ProductController::class,"update"]);
        Route::post("/delete/{product}",[ProductController::class,"delete"]);

    });
    Route::prefix("category")->group(function (){
        // categories
        Route::get("/",[CategoryController::class,"listAll"]);
        Route::get("/create",[CategoryController::class,"create"]);
        Route::post("/create",[CategoryController::class,"store"]);
    });
});







Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
