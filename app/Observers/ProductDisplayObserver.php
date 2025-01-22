<?php

namespace App\Observers;

use App\Contracts\ProductDisplayServiceInterface;
use App\Models\ProductDisplay;

class ProductDisplayObserver
{
    public function __construct(protected ProductDisplayServiceInterface $ProductDisplayService) {}

    /**
     * Handle the ProductDisplay "created" event.
     */
    public function created(ProductDisplay $ProductDisplay): void
    {
        $this->ProductDisplayService->sendNotification(
            'Hasil Olahan berhasil ditambahkan.',
            auth()->user()->name . ' menambahkan hasil olahan baru.',
            'heroicon-o-check-circle',
            'success',
            $ProductDisplay
        );
    }

    /**
     * Handle the ProductDisplay "updated" event.
     */
    public function updated(ProductDisplay $ProductDisplay): void
    {
        $this->ProductDisplayService->sendNotification(
            'Hasil Olahan berhasil diupdate.',
            auth()->user()->name . ' mengubah hasil olahan ' . $ProductDisplay->title,
            'heroicon-o-check-circle',
            'success',
            $ProductDisplay
        );
    }

    /**
     * Handle the ProductDisplay "deleted" event.
     */
    public function deleted(ProductDisplay $ProductDisplay): void
    {
        $this->ProductDisplayService->sendNotification(
            'Hasil Olahan berhasil dihapus.',
            auth()->user()->name . ' menghapus Hasil Olahan ' . $ProductDisplay->title,
            'heroicon-o-exclamation-triangle',
            'danger',
            null
        );
    }

    /**
     * Handle the ProductDisplay "restored" event.
     */
    public function restored(ProductDisplay $productDisplay): void
    {
        //
    }

    /**
     * Handle the ProductDisplay "force deleted" event.
     */
    public function forceDeleted(ProductDisplay $productDisplay): void
    {
        //
    }
}
