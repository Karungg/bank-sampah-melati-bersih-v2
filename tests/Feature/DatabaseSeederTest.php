<?php

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;

it('seeder', function () {
    $this->seed([
        ProductSeeder::class,
        UserSeeder::class,
        CustomerSeeder::class
    ]);

    Transaction::withoutEvents(function () {
        $transactions = Transaction::factory()
            ->count(3)
            ->has(TransactionDetail::factory()->count(1), 'transactionDetails')
            ->create();

        foreach ($transactions as $transaction) {
            DB::table('transaction_reports')
                ->insert([
                    'id' => $transaction->id,
                    'transaction_code' => $transaction->transaction_code,
                    'total_quantity' => $transaction->total_quantity,
                    'total_weight' => $transaction->total_weight,
                    'total_liter' => $transaction->total_liter,
                    'total_amount' => $transaction->total_amount,
                    'type' => $transaction->type,
                    'location' => $transaction->location,
                    'user_id' => $transaction->user_id,
                    'customer_id' => $transaction->customer_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
        }

        foreach ($transaction->transactionDetails as $transaction) {
            DB::table('transaction_detail_reports')
                ->insert([
                    'id' => $transaction->id,
                    'quantity' => $transaction->quantity,
                    'weight' => $transaction->weight,
                    'liter' => $transaction->liter,
                    'current_price' => $transaction->current_price,
                    'subtotal' => $transaction->subtotal,
                    'transaction_id' => $transaction->transaction_id,
                    'product_id' => $transaction->product_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
        }
    });
});
