<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect([
            ['Pemilihan', 'pemilihan'],
            ['Penimbangan', 'penimbangan'],
        ])->map(function ($category, $index) {
            $timestamp = now();
            return [
                'id' => Str::uuid(),
                'title' => $category[0],
                'slug' => $category[1],
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        });


        DB::table('categories')->insert($categories->toArray());

        Post::withoutEvents(function () {
            Post::factory(10)->create();
        });
    }
}
