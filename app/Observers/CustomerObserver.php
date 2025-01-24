<?php

namespace App\Observers;

use App\Contracts\CustomerServiceInterface;
use App\Contracts\NotificationServiceInterface;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;

class CustomerObserver
{
    public function __construct(
        protected CustomerServiceInterface $customerService,
        protected NotificationServiceInterface $notificationService
    ) {}

    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        $this->notificationService->sendSuccessNotification(
            'Nasabah berhasil ditambahkan',
            auth()->user()->name . ' menambahkan nasabah ' . $customer->full_name . '.',
            $customer,
            'filament.admin.users.resources.customers.index',
            'full_name',
            'adminManagement'
        );
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {
        $this->customerService->updateImages($customer);

        $this->notificationService->sendUpdateNotification(
            'Nasabah berhasil diupdate',
            auth()->user()->name . ' mengupdate nasabah ' . $customer->full_name . '.',
            $customer,
            'filament.admin.users.resources.customers.index',
            'full_name',
            'adminManagement'
        );
    }

    /**
     * Handle the Customer "deleted" event.
     */
    public function deleted(Customer $customer): void
    {
        $this->customerService->deleteImages($customer);

        $this->notificationService->sendDeleteNotification(
            'Nasabah berhasil dihapus',
            auth()->user()->name . ' menghapus nasabah ' . $customer->full_name . '.',
            $customer,
            'adminManagement'
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
