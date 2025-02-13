<?php

namespace App\Contracts;

interface TransactionServiceInterface
{
    public function generateCode(): string;

    public function calculateTransaction(array $data, string $type): array;

    public function saveTransactionDetails(string $transactionId, array $products, string $type);
}
