<?php

namespace App\Services;

use App\Contracts\PostServiceInterface;
use App\Models\Post;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class PostService implements PostServiceInterface
{
    public function sendNotification(
        string $title,
        ?string $body,
        string $icon,
        string $type,
        ?Post $post = null,
    ): void {
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

        $notification->actions([
            Action::make('Lihat')
                ->url(route('filament.admin.posts.resources.posts.index', ['tableSearch' => $post->title]))
        ]);

        $recipient = User::role('admin')->get();
        $notification->sendToDatabase($recipient);
    }
}
