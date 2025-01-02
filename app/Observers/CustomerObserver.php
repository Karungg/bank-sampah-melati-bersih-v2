<?php

namespace App\Observers;

use App\Contracts\CustomerServiceInterface;
use App\Models\Customer;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class CustomerObserver
{
    public function __construct(protected CustomerServiceInterface $customerService) {}

    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        $this->customerService->sendNotification(
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
        $this->customerService->sendNotification(
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
        $this->customerService->sendNotification(
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
