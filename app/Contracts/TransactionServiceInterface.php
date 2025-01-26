<?php

namespace App\Contracts;

interface TransactionServiceInterface
{
    public function unitCheck(string $unit, ?string $productId): bool;

    public function generateCode(): string;

    public function calculateTransaction($data): array;

    public function getProductById(string $id);

    public function saveTransactionDetails(string $transactionId, array $products);
}
