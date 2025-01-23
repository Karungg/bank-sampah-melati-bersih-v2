<?php

namespace App\Contracts;

interface ProductServiceInterface
{
    public function generateCode(string $productName): string;
}
