<?php

namespace App\Services;

use App\Contracts\ProductDisplayServiceInterface;
use App\Models\ProductDisplay;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductDisplayService implements ProductDisplayServiceInterface
{
    public function updateImage(ProductDisplay $productDisplay): void
    {
        try {
            if ($productDisplay->isDirty('image') && $productDisplay->getOriginal('image') != null) {
                Storage::disk('public')->delete($productDisplay->getOriginal('image'));
            }
        } catch (Exception $e) {
            Log::error("Failed to update image in product display resource", [
                "product_display_id" => $productDisplay->id,
                "message" => $e->getMessage(),
            ]);
            throw new Exception("Terjadi kesalahan saat memproses. Silahkan coba lagi nanti.");
        }
    }

    public function deleted(ProductDisplay $productDisplay): void
    {
        try {
            if ($productDisplay->image) {
                Storage::disk('public')->delete($productDisplay->image);
            }
        } catch (Exception $e) {
            Log::error("Failed to delete image in product display resource", [
                "product_display_id" => $productDisplay->id,
                "message" => $e->getMessage(),
            ]);
            throw new Exception("Terjadi kesalahan saat memproses. Silahkan coba lagi nanti.");
        }
    }
}
