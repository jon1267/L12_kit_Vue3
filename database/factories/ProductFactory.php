<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        $categories = Category::query()->pluck('id')->toArray(); //на момент запуска должно быть создано
        $users = User::query()->pluck('id')->toArray(); //на момент запуска должно быть создано

        return [
            'name'  => fake()->sentence(),
            'brand' => fake()->sentence(2),
            'price' => fake()->randomDigitNot(0) * 100,
            'weight' => fake()->randomFloat(2, 20, 50),
            'description' => fake()->text(),
            'user_id' => fake()->randomElement($users),
            'category_id' => fake()->randomElement($categories),

        ];
    }
}
