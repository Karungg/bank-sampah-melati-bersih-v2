<?php

namespace App\Contracts;

use App\Models\User;

interface UserServiceInterface
{
    public function updateProfile(User $user);

    public function deleteProfile(User $user);

    public function getTextCreateNotification(User $user): array;

    public function getTextUpdateNotification(User $user): array;

    public function getTextDeleteNotification(User $user): array;
}
