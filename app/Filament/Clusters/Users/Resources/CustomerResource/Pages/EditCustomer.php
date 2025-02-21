<?php

namespace App\Filament\Clusters\Users\Resources\CustomerResource\Pages;

use App\Filament\Clusters\Users\Resources\CustomerResource;
use App\Models\User;
use Exception;
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
            Actions\DeleteAction::make()
        ];
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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($data['user_id']);

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
