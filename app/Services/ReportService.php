<?php

namespace App\Services;

use App\Contracts\ReportServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Transaction;

class ReportService implements ReportServiceInterface
{
    public function customerReportSave(Transaction $transaction): void
    {
        try {
            DB::transaction(function () use ($transaction) {
                DB::table('customer_reports')
                    ->insert([
                        'id' => Str::uuid(),
                        'transaction_code' => $transaction->transaction_code,
                        'debit' => $transaction->customer->account->debit + $transaction->total_amount,
                        'credit' => $transaction->customer->account->credit ?? 0,
                        'balance' => $transaction->customer->account->balance + $transaction->total_amount,
                        'type' => $transaction->type,
                        'customer_id' => $transaction->customer_id,
                        'created_at' => $transaction->created_at,
                        'updated_at' => $transaction->updated_at
                    ]);
            });
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat memproses transaksi. Silahkan coba lagi nanti.');
        }
    }
}
