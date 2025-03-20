<?php

namespace App\Services;

use App\Contracts\CustomerServiceInterface;
use App\Models\Customer;
use App\Models\User;
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

    public function saveUser(array $data): array
    {
        try {
            DB::beginTransaction();
            $user = null;
            User::withoutEvents(function () use (&$user, $data) {
                $user = User::create([
                    'name' => $data['full_name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'avatar_url' => $data['avatar_url']
                ]);
            });

            if ($user) {
                $user->assignRole('customer');
                $data['user_id'] = $user->id;
            }
            DB::commit();
            return $data;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Terjadi kesalahan saat menambahkan nasabah. Coba lagi nanti.');
        }
    }

    public function editUser(array $data): array
    {
        try {
            DB::beginTransaction();
            $user = User::find($data['user_id']);

            $user->fill([
                'name' => $data['full_name'],
                'email' => $data['email'],
                'password' => $data['password'] ?? $user->password,
                'avatar_url' => $data['avatar_url'],
            ]);

            if ($user->isDirty('avatar_url') && $user->getOriginal('avatar_url') != null) {
                Storage::disk('public')->delete($user->getOriginal('avatar_url'));
            }

            $user->saveQuietly();
            DB::commit();
            return $data;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Terjadi kesalahan saat mengupdate nasabah. Coba lagi nanti.');
        }
    }
}
