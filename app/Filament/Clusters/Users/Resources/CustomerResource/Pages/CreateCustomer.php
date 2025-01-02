<?php

namespace App\Filament\Clusters\Users\Resources\CustomerResource\Pages;

use App\Filament\Clusters\Users\Resources\CustomerResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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
            } else {
                throw new \Exception('Nasabah gagal ditambahkan.');
            }

            DB::commit();

            return $data;
        } catch (\Throwable $e) {
            DB::rollBack();
        }
    }
}
