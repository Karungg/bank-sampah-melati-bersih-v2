<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionDetail>
 */
class TransactionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => fake()->numberBetween(0, 100),
            'weight' => fake()->numberBetween(0, 100),
            'liter' => fake()->numberBetween(0, 100),
            'current_price' => fake()->randomNumber(5, true),
            'subtotal' => fake()->randomNumber(5, true),
            'product_id' => Product::inRandomOrder()->value('id')
        ];
    }
}
