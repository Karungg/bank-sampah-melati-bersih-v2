<?php

namespace App\Filament\Clusters\Users\Resources\CustomerResource\Pages;

use App\Filament\Clusters\Users\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Hapus nasabah')
                ->modalDescription('Apakah anda yakin ingin menghapus nasabah ini? Hal ini tidak dapat dibatalkan.')
                ->modalSubmitActionLabel('Hapus')
                ->color('danger')
                ->form([
                    TextInput::make('confirm')
                        ->required()
                        ->label('Ketik "Saya yakin ingin menghapus" untuk konfirmasi.'),
                ])
                ->action(function (array $data, Customer $record) {
                    if ($data['confirm'] !== 'Saya yakin ingin menghapus') {
                        Notification::make()
                            ->title('Konfirmasi tidak sesuai')
                            ->danger()
                            ->send();

                        return;
                    }

                    $record->delete();

                    Notification::make()
                        ->title('Admin berhasil dihapus.')
                        ->success()
                        ->send();
                })
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
        $user = User::findOrFail($data['user_id']);

        $user->fill([
            'name' => $data['full_name'],
            'email' => $data['email'],
            'password' => $data['password'] ?? $user->password,
            'avatar_url' => $data['avatar_url'],
        ]);

        if ($user->isDirty('avatar_url') && $user->getOriginal('avatar_url') != null) {
            Storage::delete($user->getOriginal('avatar_url'));
        }

        $user->saveQuietly();

        return $data;
    }
}
