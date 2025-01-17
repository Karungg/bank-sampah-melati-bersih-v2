<?php

namespace App\Contracts;

use App\Models\Category;

interface CategoryServiceInterface
{
    public function sendNotification(
        string $title,
        string $body,
        string $icon,
        string $type,
        ?Category $category
    ): void;
}
