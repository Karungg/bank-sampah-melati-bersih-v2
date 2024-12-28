<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Route;

class ProductObserver
{
    protected function sendNotification(string $title, string $body, string $icon, string $type, ?Product $product = null): void
    {
        $recipient = User::role('admin')->get();
        $notification = Notification::make()
            ->title($title)
            ->icon($icon)
            ->body($body);

        if ($type === 'success') {
            $notification->success();
        } elseif ($type === 'warning') {
            $notification->warning();
        } elseif ($type === 'danger') {
            $notification->danger();
        }

        if ($product) {
            $notification->actions([
                Action::make('Lihat')
                    ->url(route('filament.admin.resources.products.view', $product->id)),
            ]);
        }

        $notification->sendToDatabase($recipient);
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this->sendNotification(
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
            $this->sendNotification(
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
            $this->sendNotification(
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
        $this->sendNotification(
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
        $this->sendNotification(
            'Kategori Sampah berhasil dihapus secara permanen.',
            auth()->user()->name . ' menghapus permanen Kategori Sampah ' . $product->title . '.',
            'heroicon-o-exclamation-triangle',
            'danger'
        );
    }
}
