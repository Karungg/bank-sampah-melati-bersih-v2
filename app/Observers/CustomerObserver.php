<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class CustomerObserver
{
    protected function sendNotification(
        string $title,
        ?string $body,
        string $icon,
        string $type,
        ?Customer $customer = null,
    ) {
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

    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        $this->sendNotification(
            'Nasabah berhasil ditambahkan',
            auth()->user()->name . ' menambahkan nasabah ' . $customer->full_name,
            'heroicon-o-check-circle',
            'success',
            $customer
        );
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {
        $this->sendNotification(
            'Nasabah berhasil diubah',
            auth()->user()->name . ' mengubah nasabah ' . $customer->full_name,
            'heroicon-o-check-circle',
            'warning',
            $customer
        );
    }

    /**
     * Handle the Customer "deleted" event.
     */
    public function deleted(Customer $customer): void
    {
        $this->sendNotification(
            'Nasabah berhasil dihapus',
            auth()->user()->name . ' menghapus nasabah ' . $customer->full_name,
            'heroicon-o-exclamation-triangle',
            'danger',
            $customer
        );
    }

    /**
     * Handle the Customer "restored" event.
     */
    public function restored(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     */
    public function forceDeleted(Customer $customer): void
    {
        //
    }
}
