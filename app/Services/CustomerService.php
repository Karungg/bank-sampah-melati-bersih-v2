<?php

namespace App\Services;

use App\Contracts\CustomerServiceInterface;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerService implements CustomerServiceInterface
{
    public function updateImages(Customer $customer): void
    {
        try {
            $oldIdentityCard = $customer->getOriginal('identity_card_photo');

            if ($customer->isDirty('identity_card_photo') && $oldIdentityCard) {
                Storage::disk('public')->delete($oldIdentityCard);
            }
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat memproses. Silahkan coba lagi nanti.');
        }
    }


    public function deleteImages(Customer $customer): void
    {
        try {
            $user = DB::table('users')->where('id', $customer->user_id);

            if ($customer->identity_card_photo != null) {
                Storage::disk('public')->delete($customer->identity_card_photo);
            }

            if ($user->value('avatar_url') != null) {
                Storage::disk('public')->delete($user->value('avatar_url'));
            }
            $user->delete();
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat memproses. Silahkan coba lagi nanti.');
        }
    }
}
