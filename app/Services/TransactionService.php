<?php

namespace App\Services;

use App\Contracts\TransactionServiceInterface;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Account;
use App\Models\WeightedProduct;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionService implements TransactionServiceInterface
{
    public function generateCode(): string
    {
        $date = now()->format('Ymd');

        $latestTransaction = Transaction::whereDate('created_at', now())
            ->latest()
            ->value('transaction_code');

        $sequence = $latestTransaction ? (int)substr($latestTransaction, -3) + 1 : 1;

        return $date . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    public function calculateTransaction(array $data): array
    {
        try {
            $productIds = array_column($data['transactionDetails'], 'product_id');
            $products = Product::whereIn('id', $productIds)->get(['id', 'unit', 'price'])->keyBy('id');

            $totals = [
                'quantity' => 0,
                'weight' => 0,
                'liter' => 0,
                'subtotal' => 0,
            ];

            foreach ($data['transactionDetails'] as $detail) {
                $product = $products[$detail['product_id']];
                $totals['quantity'] += $detail['quantity'];
                $totals['weight'] += $detail['weight'];
                $totals['liter'] += $detail['liter'];
                $totals['subtotal'] += $this->calculateSubtotal($product, $detail);
            }

            return [
                ...$data,
                'transaction_code' => $this->generateCode(),
                'total_quantity' => $totals['quantity'],
                'total_weight' => $totals['weight'],
                'total_liter' => $totals['liter'],
                'total_amount' => $totals['subtotal'],
                'type' => 'weighing',
                'location' => 'Lapangan',
                'user_id' => auth()->id(),
            ];
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat memproses transaksi. Silahkan coba lagi nanti.');
        }
    }

    public function saveTransactionDetails(string $transactionId, array $products): void
    {
        DB::transaction(function () use ($transactionId, $products) {
            $productIds = array_column($products, 'product_id');
            $productsData = Product::whereIn('id', $productIds)->get(['id', 'unit', 'price'])->keyBy('id');

            $transactionDetails = [];
            foreach ($products as $product) {
                $productModel = $productsData[$product['product_id']];
                $transactionDetails[] = [
                    'id' => Str::uuid(),
                    'quantity' => $product['quantity'],
                    'weight' => $product['weight'],
                    'liter' => $product['liter'],
                    'current_price' => $productModel->price,
                    'subtotal' => $this->calculateSubtotal($productModel, $product),
                    'transaction_id' => $transactionId,
                    'product_id' => $product['product_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            TransactionDetail::insert($transactionDetails);

            $transaction = Transaction::findOrFail($transactionId, ['total_amount', 'customer_id']);

            Account::where('customer_id', $transaction->customer_id)
                ->incrementEach([
                    'debit' => $transaction->total_amount,
                    'balance' => $transaction->total_amount,
                ]);
        });
    }

    protected function calculateSubtotal(Product $product, array $detail): float
    {
        return match ($product->unit) {
            'pcs' => $product->price * $detail['quantity'],
            'kg' => $product->price * $detail['weight'],
            'liter' => $product->price * $detail['liter'],
            default => throw new Exception('Unit produk tidak valid.'),
        };
    }
}
