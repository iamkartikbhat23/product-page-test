<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed 5 users
        \App\Models\User::factory(5)->create();
        // Seed 10 products
        \App\Models\Product::factory(10)->create();
        // Seed 5 images for each product
        \App\Models\Product::all()->each(function ($product) {
            \App\Models\ProductImage::factory(5)->create(['product_id' => $product->id]);
        });
        // Seed 1 discount for each product
        \App\Models\Product::all()->each(function ($product) {
            \App\Models\ProductDiscount::factory(1)->create(['product_id' => $product->id]);
        });
    }
}
