<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => fake()->words(3, true),
            'slug' => fake()->slug(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 10, 1000),
            'discount_price' => fake()->randomElement([null, fake()->randomFloat(2, 5, 500)]),
            'image' => fake()->imageUrl(),
            'gallery' => json_encode([fake()->imageUrl(), fake()->imageUrl()]),
            'stock' => fake()->numberBetween(0, 100),
            'is_available' => true,
            'is_featured' => fake()->boolean(),
        ];
    }
}