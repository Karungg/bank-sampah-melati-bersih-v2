<?php

namespace App\Observers;

use App\Contracts\CustomerServiceInterface;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $oldCustomerData = $this->customerService->getOldById($customer->id);

        $oldProfile = $oldCustomerData->avatar_url;
        if ($oldProfile && $customer->avatar_url !== $oldProfile) {
            Storage::delete($oldProfile);
        }

        $oldIdentity = $oldCustomerData->identity_card_photo;
        if ($oldIdentity && $customer->identity_card_photo !== $oldIdentity) {
            Storage::delete($oldIdentity);
        }

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
        $oldCustomerData = $this->customerService->getOldById($customer->id);

        if ($oldCustomerData->avatar_url) {
            Storage::delete($oldCustomerData->avatar_url);
        }

        if ($oldCustomerData->identity_card_photo) {
            Storage::delete($oldCustomerData->identity_card_photo);
        }

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
