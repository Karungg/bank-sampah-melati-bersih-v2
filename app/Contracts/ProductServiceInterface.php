<?php

namespace App\Contracts;

use App\Models\Product;

interface ProductServiceInterface
{
    public function generateCode(string $productName): string;

    public function sendNotification(
        string $title,
        string $body,
        string $icon,
        string $type,
        ?Product $product = null
    ): void;
}
