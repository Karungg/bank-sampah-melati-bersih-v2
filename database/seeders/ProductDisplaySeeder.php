<?php

namespace Database\Seeders;

use App\Models\ProductDisplay;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductDisplaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductDisplay::factory(3)->create();
    }
}
