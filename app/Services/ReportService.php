<?php

namespace App\Services;

use App\Contracts\ReportServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\WithDrawal;

class ReportService implements ReportServiceInterface
{
    public function customerWeighingReportSave(Transaction $transaction): void
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

    public function customerWithDrawalReportSave(WithDrawal $withDrawal): void
    {
        try {
            DB::transaction(function () use ($withDrawal) {
                DB::table('customer_reports')
                    ->insert([
                        'id' => Str::uuid(),
                        'transaction_code' => $withDrawal->with_drawal_code,
                        'debit' => $withDrawal->customer->account->debit,
                        'credit' => $withDrawal->customer->account->credit,
                        'balance' => $withDrawal->customer->account->balance,
                        'type' => 'with drawal',
                        'customer_id' => $withDrawal->customer_id,
                        'created_at' => $withDrawal->created_at,
                        'updated_at' => $withDrawal->updated_at
                    ]);
            });
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat memproses transaksi. Silahkan coba lagi nanti.');
        }
    }

    public function transactionReportSave(Transaction $transaction): void
    {
        try {
            DB::transaction(function () use ($transaction) {
                DB::table('transaction_reports')
                    ->insert([
                        'id' => Str::uuid(),
                        'transaction_code' => $transaction->transaction_code,
                        'total_quantity' => $transaction->total_quantity,
                        'total_weight' => $transaction->total_weight,
                        'total_liter' => $transaction->total_liter,
                        'total_amount' => $transaction->total_amount,
                        'type' => $transaction->type,
                        'location' => $transaction->location,
                        'user_id' => $transaction->user_id,
                        'customer_id' => $transaction->customer_id,
                        'created_at' => $transaction->created_at,
                        'updated_at' => $transaction->updated_at
                    ]);
            });
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat memproses transaksi. Silahkan coba lagi nanti.');
        }
    }

    public function transactionDetailReportSave(TransactionDetail $transactionDetail): void
    {
        try {
            DB::transaction(function () use ($transactionDetail) {
                DB::table('transaction_detail_reports')
                    ->insert([
                        'id' => Str::uuid(),
                        'quantity' => $transactionDetail->quantity,
                        'weight' => $transactionDetail->weight,
                        'liter' => $transactionDetail->liter,
                        'current_price' => $transactionDetail->current_price,
                        'total_amount' => $transactionDetail->total_amount,
                        'transaction_id' => $transactionDetail->transaction_id,
                        'product_id' => $transactionDetail->product_id,
                        'created_at' => $transactionDetail->created_at,
                        'updated_at' => $transactionDetail->updated_at
                    ]);
            });
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat memproses transaksi. Silahkan coba lagi nanti.');
        }
    }

    public function transactionSaleReportSave(Transaction $transaction): void {}
}
