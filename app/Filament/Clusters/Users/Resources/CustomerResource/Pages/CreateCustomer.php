<?php

namespace App\Filament\Clusters\Users\Resources\CustomerResource\Pages;

use App\Filament\Clusters\Users\Resources\CustomerResource;
use App\Models\User;
use Exception;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        try {
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

            return $data;
        } catch (Exception $e) {
            throw new Exception('Terjadi kesalahan saat menambahkan nasabah. Coba lagi nanti.');
        }
    }
}
