<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'name' =>$this->faker->words(3, true),
           'description' => $this->faker->words(20, true),
           'slug' =>  function (array $attributes) {
                        return Str::slug($attributes['name']);
                    },
           'price' => ceil($this->faker->numberBetween(50, 1000)/10) * 10,
           'active' => $this->faker->boolean()
        ];
    }
}
