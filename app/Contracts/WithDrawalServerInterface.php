<?php

namespace App\Contracts;

interface WithDrawalServerInterface
{
    public function generateCode(): string;

    public function store(string $customerId, int $amount): bool;
}
