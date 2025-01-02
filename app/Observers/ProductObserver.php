<?php

namespace App\Observers;

use App\Contracts\ProductServiceInterface;
use App\Models\Product;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Route;

class ProductObserver
{
    public function __construct(protected ProductServiceInterface $productService) {}

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this->productService->sendNotification(
            'Kategori Sampah berhasil ditambahkan.',
            auth()->user()->name . ' menambahkan Kategori Sampah baru.',
            'heroicon-o-check-circle',
            'success',
            $product
        );
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        if (!$product->wasChanged()) {
            $this->productService->sendNotification(
                'Kategori Sampah berhasil diubah.',
                auth()->user()->name . ' mengubah Kategori Sampah ' . $product->title . '.',
                'heroicon-o-exclamation-circle',
                'warning',
                $product
            );
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        if ($product->exists) {
            $this->productService->sendNotification(
                'Kategori Sampah berhasil dihapus.',
                auth()->user()->name . ' menghapus Kategori Sampah ' . $product->title . '.',
                'heroicon-o-check-circle',
                'danger'
            );
        }
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        $this->productService->sendNotification(
            'Kategori Sampah berhasil dipulihkan.',
            auth()->user()->name . ' memulihkan Kategori Sampah ' . $product->title . '.',
            'heroicon-o-check',
            'success',
            $product
        );
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        $this->productService->sendNotification(
            'Kategori Sampah berhasil dihapus secara permanen.',
            auth()->user()->name . ' menghapus permanen Kategori Sampah ' . $product->title . '.',
            'heroicon-o-exclamation-triangle',
            'danger'
        );
    }
}
