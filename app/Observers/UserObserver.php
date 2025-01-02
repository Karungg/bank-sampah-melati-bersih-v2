<?php

namespace App\Observers;

use App\Contracts\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    public function __construct(protected UserServiceInterface $userService) {}

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $title = url()->livewire_current() == 'filament.admin.users.resources.admin-users.index'
            ? 'Admin baru berhasil ditambahkan'
            : 'Pengurus baru berhasil ditambahkan';

        $body = url()->livewire_current() == 'filament.admin.users.resources.admin-users.index'
            ? auth()->user()->name . ' menambahkan admin baru ' . $user->name
            : auth()->user()->name . ' menambahkan pengurus baru ' . $user->name;

        $this->userService->sendNotification(
            $title,
            $body,
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

        $this->userService->sendNotification(
            "Profile berhasil diubah",
            'Anda baru saja mengubah profile',
            "heroicon-o-check-circle",
            "success"
        );
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $this->userService->sendNotification(
            "Pengguna berhasil dihapus",
            auth()->user()->name . " menghapus pengguna " . $user->name,
            "heroicon-o-exclamation-triangle",
            "danger",
            null,
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
