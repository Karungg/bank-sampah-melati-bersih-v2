<?php

namespace App\Contracts;

use App\Models\ProductDisplay;

interface ProductDisplayServiceInterface
{
    public function updateImage(ProductDisplay $productDisplay): void;

    public function deleted(ProductDisplay $productDisplay): void;
}
