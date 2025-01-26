<?php

namespace App\Services;

use App\Contracts\TransactionServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionServiceInterface
{
    public function unitCheck(string $unit, ?string $productId): bool
    {
        $productUnit = DB::table('products')
            ->where('id', $productId)
            ->value('unit');

        return $productUnit != $unit;
    }

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

                $product = DB::table('products')
                    ->where('id', $detail['product_id'])
                    ->first(['unit', 'price']);

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
            return $data;
        }
    }
}
