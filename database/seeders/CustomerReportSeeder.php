<?php

namespace Database\Seeders;

use App\Models\Reports\CustomerReport;
use Illuminate\Database\Seeder;

class CustomerReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomerReport::factory()->count(100)->create();
    }
}
