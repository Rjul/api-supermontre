<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'                   => fake()->name(),
            'description'             => fake()->realText(200),
            'imageUrl'                => fake()->imageUrl(),
            'price'                   => fake()->numberBetween(4456, 24000),
            'quantity'                => fake()->numberBetween(1, 24),
            'category_id'             => Category::all()->random()->id,
        ];
    }

}
