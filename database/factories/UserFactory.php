<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'admin',
                'email' => 'admin@gmail.com'
            ];
        })->afterCreating(function (User $user) {
            $user->assignRole('admin');
        });
    }

    public function management(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'management',
                'email' => 'management@gmail.com'
            ];
        })->afterCreating(function (User $user) {
            $user->assignRole('management');
        });
    }

    public function customer(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'customer',
                'email' => 'customer@gmail.com'
            ];
        })->afterCreating(function (User $user) {
            $user->assignRole('customer');
        });
    }
}
