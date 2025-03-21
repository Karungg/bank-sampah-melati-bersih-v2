<?php

namespace App\Services;

use App\Contracts\ProductServiceInterface;
use App\Models\WeightedProduct;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function createWeightedProduct(string $id): void
    {
        try {
            WeightedProduct::create([
                'product_id' => $id
            ]);
        } catch (Exception $e) {
            Log::error("Failed to create weighted product", [
                "product_id" => $id,
                "message" => $e->getMessage(),
            ]);
            throw new Exception("Terjadi kesalahan saat memproses. Silahkan coba lagi nanti.");
        }
    }

    public function deleteWeightedProduct(string $id): void
    {
        try {
            WeightedProduct::where('product_id', $id)->delete();
        } catch (Exception $e) {
            Log::error("Failed to delete weighted product", [
                "product_display_id" => $id,
                "message" => $e->getMessage(),
            ]);
            throw new Exception("Terjadi kesalahan saat memproses. Silahkan coba lagi nanti.");
        }
    }
}
