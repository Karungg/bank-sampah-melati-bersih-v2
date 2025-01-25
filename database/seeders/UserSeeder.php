<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFilePath = base_path('database/seeders/data/management.csv');

        $csv = Reader::createFromPath($csvFilePath, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        User::withoutEvents(function () use ($records) {
            User::factory()->admin()->create(); // Admin
            User::factory()->management()->create(); // Management

            foreach ($records as $record) {
                User::factory()->management()->create([
                    'name' => $record['name'],
                    'email' => strtolower(str_replace(' ', '', $record['name'])) . '@filament.com'
                ]);
            } // Management from excel

            User::factory()->customer()->create(); // Customer
        });
    }
}
