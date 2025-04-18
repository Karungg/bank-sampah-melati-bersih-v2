<?php

namespace App\Contracts;

interface ProductServiceInterface
{
    public function generateCode(string $productName): string;

    public function createWeightedProduct(string $id): void;

    public function deleteWeightedProduct(string $id): void;
}
