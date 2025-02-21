<?php

namespace App\Observers;

use App\Contracts\NotificationServiceInterface;
use App\Contracts\PostServiceInterface;
use App\Models\Post;

class PostObserver
{
    public function __construct(
        protected PostServiceInterface $postService,
        protected NotificationServiceInterface $notificationService
    ) {}

    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $this->notificationService->sendSuccessNotification(
            'Kegiatan berhasil ditambahkan.',
            auth()->user()->name . ' menambahkan kegiatan baru.',
            $post,
            'filament.admin.posts.resources.posts.index',
            'title',
            'admin'
        );
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $this->postService->updateImage($post);

        $this->notificationService->sendUpdateNotification(
            'Kegiatan berhasil diupdate.',
            auth()->user()->name . ' mengupdate kegiatan ' . $post->title . '.',
            $post,
            'filament.admin.posts.resources.posts.index',
            'title',
            'admin'
        );
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        $this->postService->deleted($post);

        $this->notificationService->sendDeleteNotification(
            'Kegiatan berhasil dihapus.',
            auth()->user()->name . ' menghapus kegiatan ' . $post->title . '.',
            'filament.admin.posts.resources.posts.index',
            'admin'
        );
    }
}
