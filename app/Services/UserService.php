<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class UserService implements UserServiceInterface
{
    public function sendNotification(
        string $title,
        ?string $body,
        string $icon,
        string $type,
        ?User $user = null,
        ?bool $recipient = null
    ): void {
        $notification = Notification::make()
            ->title($title)
            ->body($body)
            ->icon($icon);

        if ($type == 'success') {
            $notification->success();
        } elseif ($type == 'danger') {
            $notification->danger();
        }

        if ($user) {
            $route = url()->livewire_current() == 'filament.admin.users.resources.admin-users.index'
                ? 'filament.admin.users.resources.admin-users.index'
                : 'filament.admin.users.resources.management-users.index';

            $notification->actions([
                Action::make('Lihat')
                    ->url(route($route, ['tableSearch' => $user->name]))
            ]);
        }

        $recipient = $recipient ? User::role('admin')->get() : auth()->user();
        $notification->sendToDatabase($recipient);
    }

    public function getTitleBody(User $user): array
    {
        $isAdminPage = url()->livewire_current() == 'filament.admin.users.resources.admin-users.index';

        $title = $isAdminPage
            ? 'Admin baru berhasil ditambahkan'
            : 'Pengurus baru berhasil ditambahkan';

        $body = auth()->user()->name . ' menambahkan ' . ($isAdminPage ? 'admin' : 'pengurus') . ' baru ' . $user->name;

        return [
            'title' => $title,
            'body' => $body
        ];
    }
}
