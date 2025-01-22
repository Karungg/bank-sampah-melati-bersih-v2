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
        $result = $this->userService->getTitleBody($user);

        $this->userService->sendNotification(
            $result['title'],
            $result['body'],
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
        $authUser = auth()->user();
        $recipient = null;

        if ($user->id === $authUser->id) {
            $title = 'Profil berhasil diubah';
            $body = 'Anda baru saja mengubah profil';
        } else {
            $title = 'Profil berhasil diubah';
            if ($user->hasRole('admin')) {
                $body = 'Admin ' . $authUser->name . ' merubah profil admin ' . $user->name;
                $recipient = true;
            } elseif ($user->hasRole('management')) {
                $body = $authUser->name . ' merubah profil pengurus ' . $user->name;
                $recipient = true;
            }
        }

        $oldProfile = $authUser->avatar_url;
        if ($oldProfile && $user->avatar_url !== $oldProfile) {
            Storage::delete($oldProfile);
        }

        $this->userService->sendNotification(
            $title,
            $body,
            "heroicon-o-check-circle",
            "success",
            null,
            $recipient
        );
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $isAdminPage = url()->livewire_current() == 'filament.admin.users.resources.admin-users.index';

        $title = $isAdminPage
            ? 'Admin berhasil dihapus'
            : 'Pengurus berhasil dihapus';

        $body = auth()->user()->name . ' menghapus ' . ($isAdminPage ? 'admin ' : 'pengurus ') . $user->name;

        if ($user->avatar_url) {
            Storage::delete($user->avatar_url);
        }

        $this->userService->sendNotification(
            $title,
            $body,
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
