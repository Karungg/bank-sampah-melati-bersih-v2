<?php

namespace App\Services;

use App\Contracts\CustomerServiceInterface;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerService implements CustomerServiceInterface
{
    public function updateImages(Customer $customer)
    {
        try {
            if (
                $customer->isDirty('identity_card_photo')
                && $customer->getOriginal('identity_card_photo') !== null
            ) {
                Storage::delete($customer->getOriginal('identity_card_photo'));
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function deleteImages(Customer $customer)
    {
        try {
            $user = DB::table('users')->where('id', $customer->user_id);

            if ($customer->identity_card_photo != null) {
                Storage::delete($customer->identity_card_photo);
            }

            if ($user->value('avatar_url') != null) {
                Storage::delete($user->value('avatar_url'));
            }
            $user->delete();
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}
