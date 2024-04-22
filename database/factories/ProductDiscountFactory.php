<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductDiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'type' => $this->faker->randomElement(['percent', 'amount']),
            'discount' => function (array $attributes) {
                            $actualPrice = Product::find($attributes['product_id'])->price ;
                            if($attributes['type']=='percent') {
                                $discount = ceil(rand(20,50)/10) * 10 ;
                            } else {
                                $maxDiscountRange = ceil($actualPrice / 2) ;
                                $discount = rand(1,$maxDiscountRange) ;
                            }
                            return $discount;
                        },
        ];
    }
}
