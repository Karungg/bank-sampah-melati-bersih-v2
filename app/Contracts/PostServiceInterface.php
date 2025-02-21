<?php

namespace App\Contracts;

use App\Models\Post;

interface PostServiceInterface
{
    public function updateImage(Post $post): void;

    public function deleted(Post $post): void;
}
