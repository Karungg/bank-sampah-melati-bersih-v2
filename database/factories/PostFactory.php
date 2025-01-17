<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = DB::table('users')->where('name', 'admin')->value('id');
        $title = fake()->realText(50);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => fake()->realText(5000),
            'active' => true,
            'link' => 'https://github.com/Karungg',
            'user_id' => $userId
        ];
    }
}
