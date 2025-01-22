<?php

namespace App\Contracts;

use App\Models\Customer;

interface CustomerServiceInterface
{
    public function sendNotification(
        string $title,
        ?string $body,
        string $icon,
        string $type,
        ?Customer $customer = null,
    ): void;

    public function getOldById(string $id);
}
