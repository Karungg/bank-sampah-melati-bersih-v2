<?php

namespace App\Observers;

use App\Contracts\NotificationServiceInterface;
use App\Models\ProductDisplay;

class ProductDisplayObserver
{
    public function __construct(
        protected NotificationServiceInterface $notificationService
    ) {}

    /**
     * Handle the ProductDisplay "created" event.
     */
    public function created(ProductDisplay $ProductDisplay): void
    {
        $this->notificationService->sendSuccessNotification(
            'Hasil Olahan berhasil ditambahkan.',
            auth()->user()->name . ' menambahkan hasil olahan baru.',
            $ProductDisplay,
            'filament.admin.resources.product-displays.index',
            'title',
            'admin'
        );
    }

    /**
     * Handle the ProductDisplay "updated" event.
     */
    public function updated(ProductDisplay $ProductDisplay): void
    {
        $this->notificationService->sendUpdateNotification(
            'Hasil Olahan berhasil diupdate.',
            auth()->user()->name . ' mengubah hasil olahan ' . $ProductDisplay->title,
            $ProductDisplay,
            'filament.admin.resources.product-displays.index',
            'title',
            'admin'
        );
    }

    /**
     * Handle the ProductDisplay "deleted" event.
     */
    public function deleted(ProductDisplay $ProductDisplay): void
    {
        $this->notificationService->sendDeleteNotification(
            'Hasil Olahan berhasil dihapus.',
            auth()->user()->name . ' menghapus hasil olahan ' . $ProductDisplay->title,
            'filament.admin.resources.product-displays.index',
            'admin'
        );
    }
}
