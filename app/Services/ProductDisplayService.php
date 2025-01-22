<?php

namespace App\Services;

use App\Contracts\ProductDisplayServiceInterface;
use App\Models\ProductDisplay;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class ProductDisplayService implements ProductDisplayServiceInterface
{
    public function sendNotification(
        string $title,
        ?string $body,
        string $icon,
        string $type,
        ?ProductDisplay $productDisplay = null,
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

        if ($productDisplay) {
            $notification->actions([
                Action::make('Lihat')
                    ->url(route('filament.admin.resources.product-displays.index', ['tableSearch' => $productDisplay->title]))
            ]);
        }

        $recipient = User::role('admin')->get();
        $notification->sendToDatabase($recipient);
    }
}
