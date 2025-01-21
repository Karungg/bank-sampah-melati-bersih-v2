<?php

namespace App\Contracts;

use App\Models\Post;

interface PostServiceInterface
{
    public function sendNotification(
        string $title,
        string $body,
        string $icon,
        string $type,
        ?Post $post = null
    ): void;
}
