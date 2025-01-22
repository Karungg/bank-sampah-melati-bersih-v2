<?php

namespace App\Contracts;

use App\Models\ProductDisplay;

interface ProductDisplayServiceInterface
{
    public function sendNotification(
        string $title,
        string $body,
        string $icon,
        string $type,
        ?ProductDisplay $productDisplay = null
    ): void;
}
