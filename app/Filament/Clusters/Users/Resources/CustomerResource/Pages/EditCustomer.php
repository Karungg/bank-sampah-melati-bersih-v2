<?php

namespace App\Filament\Clusters\Users\Resources\CustomerResource\Pages;

use App\Filament\Clusters\Users\Resources\CustomerResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        try {
            DB::beginTransaction();

            $user = null;
            User::withoutEvents(function () use (&$user, $data) {
                $update = [
                    'name' => $data['full_name'],
                    'email' => $data['email']
                ];

                if (!empty($data['password'])) {
                    $update['password'] = $data['password'];
                }

                if (!empty($data['avatar_url'])) {
                    $update['avatar_url'] = $data['avatar_url'];
                }

                $user = DB::table('users')
                    ->where('id', $data['user_id'])
                    ->update($update);
            });

            if (!$user) {
                throw new \Exception('Nasabah gagal diubah.');
            }

            DB::commit();

            return $data;
        } catch (\Throwable $e) {
            DB::rollBack();

            return $data;
        }
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $customer = DB::table('users')
            ->where('id', $data['user_id'])
            ->first(['email', 'avatar_url']);

        $data['email'] = $customer->email;
        $data['avatar_url'] = $customer->avatar_url;

        return $data;
    }
}
