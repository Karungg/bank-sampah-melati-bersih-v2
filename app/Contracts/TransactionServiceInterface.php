<?php

namespace App\Contracts;

interface TransactionServiceInterface
{
    public function unitCheck(string $unit, ?string $productId): bool;
}
