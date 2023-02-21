<?php

namespace App\Http\Controllers;

use App\Mail\MailOrder;
use App\Models\Category;
use App\Models\Order;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WebController extends Controller
{
    public function home(){
        $products = Products::limit(8)->orderBy("id","desc")->get();
        $categories = Category::limit(11)->orderBy("id","desc")->get();
        return view("home",compact('products','categories'));
    }

    public function aboutUs(){
        return view("about_us");
    }

    public function detail(Products $product){
        $related_products = Products::CategoryFilter($product->category_id)
            ->where("id","!=",$product->id)
            ->limit(4)
            ->get();
        $best_seller_ids = DB::table("order_products")->groupBy("product_id")
            ->orderBy("sum_qty","desc")
            ->limit(4)
            ->select(DB::raw("product_id, sum(qty) as sum_qty"))
            ->get()
            ->pluck("product_id")
            ->toArray();
//        dd($best_seller_ids);
//        $best_sellers = Product::whereIn("id",$best_seller_ids)->get();
        $best_sellers = Products::find($best_seller_ids);
        return view("user.detail",
            compact('product','related_products','best_sellers'));
    }

    public function addToCart(Products $product,Request $request){
        $request->validate([
            "qty"=>"required|numeric|min:1"
        ]);
        $cart = session()->has("cart") && is_array(session("cart"))?session("cart"):[];
        $flag = true;
        foreach ($cart as $item){
            if($item->id == $product->id){
                $item->buy_qty += $request->get("qty");
                $flag= false;
                break;
            }
        }
        if($flag){
            $product->buy_qty = $request->get("qty");
            $cart[] = $product;
        }

        session(["cart"=>$cart]);
        return redirect()->back();
    }

    public function cart(){
        $cart = session()->has("cart") && is_array(session("cart"))?session("cart"):[];
        $grand_total = 0;
        $can_checkout = true;
        foreach ($cart as $item){
            $grand_total += $item->price * $item->buy_qty;
            if($can_checkout && $item->qty ==0){
                $can_checkout =  false;
            }
        }

        return view("user.shopping-cart",compact('cart',"grand_total",'can_checkout'));
    }
    public function checkout(){
        $cart = session()->has("cart") && is_array(session("cart"))?session("cart"):[];
        if(count($cart) == 0){
            return redirect()->to("/shopping-cart");
        }
        $grand_total = 0;
        foreach ($cart as $item){
            $grand_total += $item->price * $item->buy_qty;
        }
        return view("user.checkout",compact('cart',"grand_total"));
    }

    public function remove(Products $product){
        $cart = session()->has("cart") && is_array(session("cart"))?session("cart"):[];
        foreach ($cart as $key=>$item){
            if($item->id == $product->id){
                unset($cart[$key]);
                break;
            }
        }
        session(["cart"=>$cart]);
        return redirect()->back();
    }
    public function placeHolder(Request $request){
        $request ->validate([
           "firstname"=>"required",
            "lastname"=>"required",
            "country"=>"required",
            "address"=>"required",
            "city"=>"required",
            "zip"=>"required",
            "phone"=>"required",
            "email"=>"required",
        ]);
        $cart = session()->has("cart") && is_array(session("cart"))?session("cart"):[];
        if (count($cart)==0)return abort(404);
        $grand_total = 0;
        $can_checkout = true;
        foreach ($cart as $item){
            $grand_total += $item->price * $item->buy_qty;
            if($can_checkout && $item->qty ==0){
                $can_checkout =  false;
            }
        }
        if (!$can_checkout) return abort(404);

        $order = Order::create([
            "order_date"=>now(),
            "grand_total"=>0,
            "shipping_address"=>$request->get("address"),
            "customer_tel"=>$request->get("phone"),
//            "status",
            "fullname"=>$request->get("firstname")."".$request->get("lastname"),
            "country"=>$request->get("country"),
            "city"=>$request->get("city"),
            "zip"=>$request->get("zip"),
            "email"=>$request->get("email")
        ])->createItem();
//        foreach ($cart as $item){
//            DB::table("order_products")->insert([
//               "qty"=>$item->buy_qty,
//               "price"=>$item->price,
//               "order_id"=>$order->id,
//               "product_id"=>$item->id,
//            ]);
//            session()->forget("cart");

            return redirect()->to("/");
        }
//    }
}
