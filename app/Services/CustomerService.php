<?php

namespace App\Services;

use App\Contracts\CustomerServiceInterface;
use App\Models\Customer;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

    public function getOldById(string $id)
    {
        return DB::table('users')
            ->join('customers', 'users.id', 'customers.user_id')
            ->select(['users.id', 'users.avatar_url', 'customers.id', 'customers.identity_card_photo'])
            ->where('customers.id', $id)
            ->first();
    }
}
