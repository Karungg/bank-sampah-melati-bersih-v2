<?php

namespace App\Contracts;

use App\Models\Transaction;

interface TransactionServiceInterface
{
    public function generateCode(): string;

    public function calculateTransaction(array $data, string $type): array;

    public function saveTransactionDetails(string $transactionId, array $products, string $type);
}
