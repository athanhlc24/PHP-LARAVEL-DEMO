<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Models\Products;
use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\Concerns\Has;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Category::factory(100)->create();
        Products::factory(1000)->create();
        Order::factory(50)->create();
        $admin = User::create([
           "name" => "admin",
           "email"=>"admin@localhost",
           "password"=>bcrypt("admin")
        ]);
        Admin::create([
           "user_id"=>$admin->id,
           "role"=>"ADMIN"
        ]);


        for ($i=1;$i<50;$i++){
            $random = random_int(1,10);
            $products = Products::all()->random($random);
            $grand_total = 0;
            foreach ($products as $p){
                $qty = random_int(1,10);
                $grand_total+=$qty*$p->price;
                DB::table("order_products")->insert([
                   "order_id"=>$i,
                   "product_id"=>$p->id,
                    "qty"=>$qty,
                    "price"=>$p->price
                ]);
            }
            Order::find($i)->update(["grand_total"=>$grand_total]);
        }
    }
}
