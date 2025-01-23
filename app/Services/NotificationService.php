<?php

namespace App\Services;

use App\Contracts\NotificationServiceInterface;
use App\Contracts\UserServiceInterface;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class NotificationService implements NotificationServiceInterface
{
    public function __construct(protected UserServiceInterface $userService) {}

    public function sendSuccessNotification(
        string $title,
        string $body,
        Model $model,
        string $route,
        string $tableSearch,
        $recipient = null
    ) {
        $notification = Notification::make()
            ->title($title)
            ->body($body)
            ->success()
            ->icon('heroicon-o-check-circle');

        if ($model) {
            $notification->actions([
                Action::make('Lihat')
                    ->url(route($route, ['tableSearch' => $model->$tableSearch]))
            ]);
        }

        if ($recipient == 'admin') {
            $recipient = User::role('admin')->get();
        } elseif ($recipient == 'adminManagement') {
            $recipient = User::withoutRole('customer')->get();
        }

        $notification->sendToDatabase($recipient);
    }

    public function sendUpdateNotification(
        string $title,
        string $body,
        Model $model,
        string $route,
        string $tableSearch,
        $recipient
    ) {
        $notification = Notification::make()
            ->title($title)
            ->body($body)
            ->success()
            ->icon('heroicon-o-check-circle');

        if ($model) {
            $notification->actions([
                Action::make('Lihat')
                    ->url(route($route, ['tableSearch' => $model->$tableSearch]))
            ]);
        }

        if ($recipient == 'admin') {
            $recipient = User::role('admin')->get();
        } elseif ($recipient == 'adminManagement') {
            $recipient = User::withoutRole('customer')->get();
        }

        $notification->sendToDatabase($recipient);
    }

    public function sendDeleteNotification(
        string $title,
        string $body,
        string $route,
        $recipient
    ) {
        $notification = Notification::make()
            ->title($title)
            ->body($body)
            ->danger()
            ->icon('heroicon-o-exclamation-triangle');

        if ($recipient == 'admin') {
            $recipient = User::role('admin')->get();
        } elseif ($recipient == 'adminManagement') {
            $recipient = User::withoutRole('customer')->get();
        }

        $notification->sendToDatabase($recipient);
    }
}
