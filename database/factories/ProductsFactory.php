<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name"=>$this->faker->unique()->name,
            "price" =>$this->faker->unique()->name,
            "thumbnail"=>$this->faker->name,
            "description"=>$this->faker->name,
            "qty"=>$this->faker->name,
            "category_id"=>$this->faker->text()
        ];
    }
}
