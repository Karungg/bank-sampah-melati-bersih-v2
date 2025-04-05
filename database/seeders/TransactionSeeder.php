<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::withoutEvents(function () {
            Transaction::factory()
                ->count(100)
                ->has(TransactionDetail::factory()->count(3), 'transactionDetails')
                ->create();
        });
    }
}
