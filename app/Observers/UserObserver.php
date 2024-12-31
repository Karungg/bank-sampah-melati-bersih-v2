<?php

namespace App\Observers;

use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    protected function sendNotification(
        string $title,
        ?string $body,
        string $icon,
        string $type,
        ?User $user = null,
        ?bool $recipient = null
    ) {
        $notification = Notification::make()
            ->title($title)
            ->body($body)
            ->icon($icon);

        if ($type == 'success') {
            $notification->success();
        } elseif ($type == 'warning') {
            $notification->warning();
        } elseif ($type == 'danger') {
            $notification->danger();
        }

        if ($user) {
            $notification->actions([
                Action::make('Lihat')
                    ->url(route('filament.admin.users.resources.admin-users.index', ['tableSearch' => $user->name]))
            ]);
        }

        $recipient = $recipient ? User::role('admin')->get() : auth()->user();
        $notification->sendToDatabase($recipient);
    }
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->sendNotification(
            "Pengguna Admin baru berhasil ditambahkan",
            auth()->user()->name . " menambahkan admin $user->name",
            "heroicon-o-check-circle",
            "success",
            $user,
            true
        );
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $oldProfile = auth()->user()->avatar_url;

        if ($oldProfile) {
            if ($user->avatar_url != $oldProfile) {
                Storage::delete($oldProfile);
            }
        }

        $this->sendNotification(
            "Profile berhasil diubah",
            auth()->user()->name . " mengubah pengguna admin " . $user->name,
            "heroicon-o-check-circle",
            "warning",
            $user,
            true
        );
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $this->sendNotification(
            "Pengguna Admin berhasil dihapus",
            auth()->user()->name . " menghapus pengguna admin " . $user->name,
            "heroicon-o-exclamation-triangle",
            "danger",
            $user,
            true
        );
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
