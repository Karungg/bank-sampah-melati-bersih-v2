<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
            PostSeeder::class,
            ProductDisplaySeeder::class,
            CompanyProfileSeeder::class,
            TransactionSeeder::class,
            CustomerReportSeeder::class,
        ]);
    }
}
