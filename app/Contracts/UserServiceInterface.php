<?php

namespace App\Contracts;

use App\Models\User;

interface UserServiceInterface
{
    public function sendNotification(
        string $title,
        ?string $body,
        string $icon,
        string $type,
        ?User $user = null,
        ?bool $recipient = null
    ): void;
}
