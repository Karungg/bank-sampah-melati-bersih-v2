<?php

namespace App\Services;

use App\Contracts\TransactionServiceInterface;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Account;
use App\Models\CompanyProfile;
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

    public function calculateTransaction(array $data, string $type): array
    {
        try {
            $productIds = array_column($data['transactionDetails'], 'product_id');
            $products = Product::whereIn('id', $productIds)->get(['id', 'unit', 'price'])->keyBy('id');
            $weighing_location = DB::table('company_profiles')->value('weighing_location');

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
                $this->saveWeightedProduct($product, $detail, $type);
            }

            return [
                ...$data,
                'transaction_code' => $this->generateCode(),
                'total_quantity' => $totals['quantity'],
                'total_weight' => $totals['weight'],
                'total_liter' => $totals['liter'],
                'total_amount' => $totals['subtotal'],
                'type' => $type,
                'location' => $type == 'weighing' ? $weighing_location : null,
                'user_id' => auth()->id(),
            ];
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat memproses transaksi. Silahkan coba lagi nanti.');
        }
    }

    public function saveTransactionDetails(string $transactionId, array $products, string $type): void
    {
        try {
            DB::transaction(function () use ($transactionId, $products, $type) {
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

                if ($type == 'weighing') {
                    Account::where('customer_id', $transaction->customer_id)
                        ->incrementEach([
                            'debit' => $transaction->total_amount,
                            'balance' => $transaction->total_amount,
                        ]);

                    CompanyProfile::increment('balance', $transaction->total_amount);
                } else {
                    CompanyProfile::increment('sales_balance', $transaction->total_amount);
                }
            });
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat memproses transaksi. Silahkan coba lagi.');
        }
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

    protected function saveWeightedProduct(Product $product, array $detail, string $type)
    {
        $method = $type == 'weighing' ? 'increment' : 'decrement';

        switch ($product['unit']) {
            case 'pcs':
                $product->weightedProduct->$method('total_quantity', $detail['quantity']);
                break;
            case 'kg':
                $product->weightedProduct->$method('total_weight', $detail['weight']);
                break;
            case 'liter':
                $product->weightedProduct->$method('total_liter', $detail['liter']);
                break;
            default:
                throw new Exception('Terjadi kesalahan saat memproses transaksi. Silahkan coba lagi nanti.');
        }
    }
}
