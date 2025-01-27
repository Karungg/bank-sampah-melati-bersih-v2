<?php

namespace App\Observers;

use App\Contracts\NotificationServiceInterface;
use App\Models\Category;

class CategoryObserver
{
    public function __construct(protected NotificationServiceInterface $notificationService) {}
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $this->notificationService->sendSuccessNotification(
            'Kategori kegiatan baru berhasil ditambahkan',
            auth()->user()->name . ' menambahkan kategori kegiatan ' . $category->title,
            $category,
            'filament.admin.posts.resources.categories.index',
            'title',
            'admin'
        );
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $this->notificationService->sendUpdateNotification(
            'Kategori kegiatan berhasil diupdate',
            auth()->user()->name . ' mengupdate kategori kegiatan ' . $category->title,
            $category,
            'filament.admin.posts.resources.categories.index',
            'title',
            'admin'
        );
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $this->notificationService->sendDeleteNotification(
            'Kategori kegiatan berhasil dihapus',
            auth()->user()->name . ' menghapus kategori kegiatan ' . $category->title,
            'filament.admin.posts.resources.categories.index',
            'admin'
        );
    }
}
