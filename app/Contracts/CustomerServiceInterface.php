<?php

namespace App\Contracts;

use App\Models\Customer;

interface CustomerServiceInterface
{
    public function updateImages(Customer $customer): void;

    public function deleteImages(Customer $customer): void;
}
