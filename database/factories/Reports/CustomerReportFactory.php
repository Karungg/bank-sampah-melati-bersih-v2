<?php

namespace Database\Factories\Reports;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CustomerReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = Customer::where('full_name', 'Aas Nurhasanah')->first(['id']);

        return [
            'transaction_code' => date('Ymd') . fake()->randomNumber(5, true),
            'debit' => fake()->randomNumber(5, true),
            'credit' => fake()->randomNumber(5, true),
            'type' => fake()->randomElement(['sale', 'weighing']),
            'balance' => fake()->randomNumber(5, true),
            'customer_id' => $customer->id
        ];
    }
}
