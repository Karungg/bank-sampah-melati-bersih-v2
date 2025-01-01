<?php

namespace App\Contracts;

interface AccountServiceInterface
{
    public function generateAccountNumber(string $postalCode): string;
}
