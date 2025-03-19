<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserService implements UserServiceInterface
{
    public function updateProfile(User $user): void
    {
        if (url()->livewire_current() === 'filament.admin.pages.edit-profile' && $user->isDirty('avatar_url')) {
            $avatarToDelete = $user->id === auth()->id()
                ? auth()->user()->getOriginal('avatar_url')
                : $user->getOriginal('avatar_url');

            if ($avatarToDelete) {
                Storage::disk('public')->delete($avatarToDelete);
            }
        }
    }

    public function deleteProfile(User $user): void
    {
        if ($user->avatar_url) {
            Storage::disk('public')->delete($user->avatar_url);
        }
    }

    public function getTextCreateNotification(User $user): array
    {
        $isAdminPage = url()->livewire_current() == 'filament.admin.users.resources.admin-users.index';

        $title = $isAdminPage
            ? 'Admin baru berhasil ditambahkan'
            : 'Pengurus baru berhasil ditambahkan';

        $body = auth()->user()->name . ' menambahkan ' . ($isAdminPage ? 'admin' : 'pengurus') . ' baru ' . $user->name;

        $route = url()->livewire_current() == 'filament.admin.users.resources.admin-users.index'
            ? 'filament.admin.users.resources.admin-users.index'
            : 'filament.admin.users.resources.management-users.index';

        return [
            'title' => $title,
            'body' => $body,
            'route' => $route
        ];
    }

    public function getTextUpdateNotification(User $user): array
    {
        $authUser = auth()->user();

        if ($user->id === $authUser->id) {
            $title = 'Profil berhasil diubah';
            $body = 'Anda baru saja mengubah profil';
        } else {
            $title = 'Profil berhasil diubah';
            if ($user->hasRole('admin')) {
                $body = 'Admin ' . $authUser->name . ' merubah profil admin ' . $user->name;
            } elseif ($user->hasRole('management')) {
                $body = $authUser->name . ' merubah profil pengurus ' . $user->name;
            }
        }

        $route = url()->livewire_current() == 'filament.admin.pages.edit-profile' || $user->hasRole('admin')
            ? 'filament.admin.users.resources.admin-users.index'
            : 'filament.admin.users.resources.management-users.index';

        return [
            'title' => $title,
            'body' => $body,
            'route' => $route
        ];
    }

    public function getTextDeleteNotification(User $user): array
    {
        $isAdminPage = url()->livewire_current() == 'filament.admin.users.resources.admin-users.index';

        $title = $isAdminPage
            ? 'Admin berhasil dihapus'
            : 'Pengurus berhasil dihapus';

        $body = auth()->user()->name . ' menghapus ' . ($isAdminPage ? 'admin ' : 'pengurus ') . $user->name;

        $route = url()->livewire_current() == 'filament.admin.users.resources.admin-users.index'
            ? 'filament.admin.users.resources.admin-users.index'
            : 'filament.admin.users.resources.management-users.index';

        return [
            'title' => $title,
            'body' => $body,
            'route' => $route
        ];
    }
}
