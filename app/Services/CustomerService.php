<?php

namespace App\Services;

use App\Contracts\CustomerServiceInterface;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;

class CustomerService implements CustomerServiceInterface
{
    public function updateImages(Customer $customer)
    {
        if (
            $customer->isDirty('identity_card_photo')
            && $customer->getOriginal('identity_card_photo') !== null
        ) {
            Storage::delete($customer->getOriginal('identity_card_photo'));
        }
    }
}
