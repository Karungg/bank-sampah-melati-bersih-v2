<?php

namespace App\Services;

use App\Contracts\TransactionServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionService implements TransactionServiceInterface
{
    public function generateCode(): string
    {
        $date = now()->format('Ymd');

        $latestTransaction = DB::table('transactions')
            ->whereDate('created_at', now())
            ->latest()
            ->value('transaction_code');

        $sequence = 1;
        if ($latestTransaction) {
            $latestSequence = substr($latestTransaction, -3);
            $sequence = $latestSequence + 1;
        }

        $sequence = str_pad($sequence, 3, '0', STR_PAD_LEFT);

        return $date . $sequence;
    }

    public function calculateTransaction($data): array
    {
        try {
            $totals = [
                'quantity' => 0,
                'weight' => 0,
                'liter' => 0,
                'subtotal' => 0,
            ];

            foreach ($data['transactionDetails'] as $detail) {
                $totals['quantity'] += $detail['quantity'];
                $totals['weight'] += $detail['weight'];
                $totals['liter'] += $detail['liter'];

                $product = $this->getProductById($detail['product_id']);

                if ($product->unit == 'pcs') {
                    $totals['subtotal'] += $product->price * $detail['quantity'];
                } elseif ($product->unit == 'kg') {
                    $totals['subtotal'] += $product->price * $detail['weight'];
                } elseif ($product->unit == 'liter') {
                    $totals['subtotal'] += $product->price * $detail['liter'];
                }
            }

            return array_merge($data, [
                'transaction_code' => $this->generateCode(),
                'total_quantity' => $totals['quantity'],
                'total_weight' => $totals['weight'],
                'total_liter' => $totals['liter'],
                'total_amount' => $totals['subtotal'],
                'type' => 'weighing',
                'location' => 'Lapangan',
                'user_id' => auth()->id(),
            ]);
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat memproses transaksi. Silahkan coba lagi nanti');
        }
    }

    public function saveTransactionDetails(string $transactionId, array $products)
    {
        try {
            DB::beginTransaction();

            foreach ($products as $product) {
                $getById = $this->getProductById($product['product_id']);

                if ($getById->unit == 'pcs') {
                    $subtotal = $getById->price * $product['quantity'];
                } elseif ($getById->unit == 'kg') {
                    $subtotal = $getById->price * $product['weight'];
                } elseif ($getById->unit == 'liter') {
                    $subtotal = $getById->price * $product['liter'];
                }

                // Save transaction details
                DB::table('transaction_details')
                    ->insert([
                        'id' => Str::uuid(),
                        'quantity' => $product['quantity'],
                        'weight' => $product['weight'],
                        'liter' => $product['liter'],
                        'current_price' => $getById->price,
                        'subtotal' => $subtotal,
                        'transaction_id' => $transactionId,
                        'product_id' => $product['product_id'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
            }

            // Add customer balance
            $transaction = DB::table('transactions')
                ->where('id', $transactionId)
                ->first(['total_amount', 'customer_id']);

            $account = DB::table('accounts')
                ->where('customer_id', $transaction->customer_id);

            $account->increment('debit', $transaction->total_amount);
            $account->increment('balance', $transaction->total_amount);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Terjadi kesalahan saat memproses transaksi. Silahkan coba lagi nanti.');
        }
    }

    public function getProductById(string $id)
    {
        return DB::table('products')
            ->where('id', $id)
            ->first(['unit', 'price']);
    }
}
