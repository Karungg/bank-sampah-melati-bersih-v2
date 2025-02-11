<?php

namespace App\Contracts;

interface ProductServiceInterface
{
    public function generateCode(string $productName): string;

    public function createWeightedProduct(string $id);

    public function deleteWeightedProduct(string $id);
}
