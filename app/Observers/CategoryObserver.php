<?php

namespace App\Observers;

use App\Contracts\CategoryServiceInterface;
use App\Models\Category;

class CategoryObserver
{
    public function __construct(protected CategoryServiceInterface $service) {}
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $this->service->sendNotification(
            'Kategori kegiatan baru berhasil ditambahkan',
            auth()->user()->name . ' menambahkan kategori kegiatan ' . $category->title,
            'heroicon-o-check-circle',
            'success',
            $category
        );
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $this->service->sendNotification(
            'Kategori kegiatan berhasil diubah',
            auth()->user()->name . ' mengubah kategori kegiatan ' . $category->title,
            'heroicon-o-check-circle',
            'success',
            $category
        );
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $this->service->sendNotification(
            'Kategori kegiatan berhasil dihapus',
            auth()->user()->name . ' menghapus kategori kegiatan ' . $category->title,
            'heroicon-o-exclamation-triangle',
            'danger',
            null
        );
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
