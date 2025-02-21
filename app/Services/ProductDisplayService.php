<?php

namespace App\Services;

use App\Contracts\ProductDisplayServiceInterface;
use App\Models\ProductDisplay;
use Illuminate\Support\Facades\Storage;

class ProductDisplayService implements ProductDisplayServiceInterface
{
    public function updateImage(ProductDisplay $productDisplay): void
    {
        if ($productDisplay->isDirty('image') && $productDisplay->getOriginal('image') != null) {
            Storage::disk('public')->delete($productDisplay->getOriginal('image'));
        }
    }

    public function deleted(ProductDisplay $productDisplay): void
    {
        if ($productDisplay->image) {
            Storage::disk('public')->delete($productDisplay->image);
        }
    }
}
