<?php

namespace App\Observers;

use App\Contracts\NotificationServiceInterface;
use App\Contracts\ProductServiceInterface;
use App\Models\Product;

class ProductObserver
{
    public function __construct(
        protected ProductServiceInterface $productService,
        protected NotificationServiceInterface $notificationService
    ) {}

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this->productService->createWeightedProduct($product->id);

        $this->notificationService->sendSuccessNotification(
            'Kategori Sampah berhasil ditambahkan.',
            auth()->user()->name . ' menambahkan Kategori Sampah baru.',
            $product,
            'filament.admin.resources.products.index',
            'title',
            'admin'
        );
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        if (!$product->wasChanged('deleted_at')) {
            $this->notificationService->sendUpdateNotification(
                'Kategori sampah berhasil diupdate.',
                auth()->user()->name . ' mengupdate kategori Sampah ' . $product->title . '.',
                $product,
                'filament.admin.resources.products.index',
                'title',
                'admin'
            );
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        if ($product->exists) {
            $this->notificationService->sendDeleteNotification(
                'Kategori sampah berhasil dihapus.',
                auth()->user()->name . ' menghapus kategori Sampah ' . $product->title . '.',
                'filament.admin.resources.products.index',
                'admin'
            );
        }
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        $this->notificationService->sendSuccessNotification(
            'Kategori sampah berhasil dipulihkan.',
            auth()->user()->name . ' memulihkan kategori Sampah ' . $product->title . '.',
            $product,
            'filament.admin.resources.products.index',
            'title',
            'admin'
        );
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        $this->productService->deleteWeightedProduct($product->id);

        $this->notificationService->sendDeleteNotification(
            'Kategori sampah berhasil dihapus secara permanen.',
            auth()->user()->name . ' menghapus permanen kategori Sampah ' . $product->title . '.',
            'filament.admin.resources.products.index',
            'admin'
        );
    }
}
