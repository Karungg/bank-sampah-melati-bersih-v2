<?php

namespace App\Services;

use App\Contracts\ProductServiceInterface;
use App\Models\WeightedProduct;
use Illuminate\Support\Facades\DB;

class ProductService implements ProductServiceInterface
{
    public function generateCode(string $productName): string
    {
        $prefix = strtoupper(substr($productName, 0, 2));

        $date = now()->format('Ymd');

        $latestProduct = DB::table('products')
            ->whereDate('created_at', now())
            ->latest()
            ->value('product_code');

        $sequence = 1;
        if ($latestProduct) {
            $latestSequence = substr($latestProduct, -3);
            $sequence = $latestSequence + 1;
        }

        $sequence = str_pad($sequence, 3, '0', STR_PAD_LEFT);

        return $prefix . $date . $sequence;
    }

    public function createWeightedProduct(string $id)
    {
        WeightedProduct::create([
            'product_id' => $id
        ]);
    }

    public function deleteWeightedProduct(string $id)
    {
        WeightedProduct::where('product_id', $id)->delete();
    }
}
