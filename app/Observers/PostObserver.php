<?php

namespace App\Observers;

use App\Contracts\PostServiceInterface;
use App\Models\Post;

class PostObserver
{
    public function __construct(protected PostServiceInterface $postService) {}

    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $this->postService->sendNotification(
            'Kegiatan berhasil ditambahkan.',
            auth()->user()->name . ' menambahkan kegiatan baru.',
            'heroicon-o-check-circle',
            'success',
            $post
        );
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $this->postService->sendNotification(
            'Kegiatan berhasil diupdate.',
            auth()->user()->name . ' mengubah kegiatan ' . $post->title,
            'heroicon-o-check-circle',
            'success',
            $post
        );
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        $this->postService->sendNotification(
            'Kegiatan berhasil dihapus.',
            auth()->user()->name . ' menghapus kegiatan ' . $post->title,
            'heroicon-o-check-circle',
            'success',
            $post
        );
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
