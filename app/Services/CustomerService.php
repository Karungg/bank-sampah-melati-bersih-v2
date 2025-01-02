<?php

namespace App\Services;

use App\Contracts\CustomerServiceInterface;
use App\Models\Customer;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class CustomerService implements CustomerServiceInterface
{
    public function sendNotification(
        string $title,
        ?string $body,
        string $icon,
        string $type,
        ?Customer $customer = null,
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
                ->url(route('filament.admin.users.resources.customers.index', ['tableSearch' => $customer->full_name]))
        ]);

        $recipient = User::withoutRole('customer')->get();
        $notification->sendToDatabase($recipient);
    }
}
