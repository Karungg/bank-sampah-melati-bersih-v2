<?php

namespace Database\Factories;

use App\Contracts\TransactionServiceInterface;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::whereHas('roles', function (Builder $query) {
            $query->where('name', '=', 'admin');
        })->first();

        $customer = Customer::first(['id']);

        return [
            'transaction_code' => date('Ymd') . fake()->randomNumber(5, true),
            'total_quantity' => fake()->randomNumber(2, true),
            'total_weight' => fake()->randomNumber(2, true),
            'total_liter' => fake()->randomNumber(2, true),
            'total_amount' => fake()->numberBetween(10000, 300000),
            'type' => fake()->randomElement(['weighing', 'sale']),
            'location' => 'Lapangan bola atsiri',
            'user_id' => $user->id,
            'customer_id' => $customer->id
        ];
    }
}
