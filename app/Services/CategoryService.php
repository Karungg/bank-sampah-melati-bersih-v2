<?php

namespace App\Services;

use App\Contracts\CategoryServiceInterface;
use App\Models\Category;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class CategoryService implements CategoryServiceInterface
{
    public function sendNotification(string $title, string $body, string $icon, string $type, ?Category $category): void
    {
        $recipient = User::role('admin')->get();
        $notification = Notification::make()
            ->title($title)
            ->icon($icon)
            ->body($body);

        if ($type === 'success') {
            $notification->success();
        } elseif ($type === 'warning') {
            $notification->warning();
        } elseif ($type === 'danger') {
            $notification->danger();
        }

        if ($category) {
            $notification->actions([
                Action::make('Lihat')
                    ->url(route('filament.admin.posts.resources.categories.index', ['tableSearch' => $category->title])),
            ]);
        }

        $notification->sendToDatabase($recipient);
    }
}
