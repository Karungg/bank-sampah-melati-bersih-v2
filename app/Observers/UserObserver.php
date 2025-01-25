<?php

namespace App\Observers;

use App\Contracts\NotificationServiceInterface;
use App\Contracts\UserServiceInterface;
use App\Models\User;

class UserObserver
{
    public function __construct(
        protected UserServiceInterface $userService,
        protected NotificationServiceInterface $notificationService
    ) {}

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $result = $this->userService->getTextCreateNotification($user);

        $this->notificationService->sendSuccessNotification(
            $result['title'],
            $result['body'],
            $user,
            $result['route'],
            'name',
            'admin'
        );
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $result = $this->userService->getTextUpdateNotification($user);

        $this->userService->updateProfile($user);

        $this->notificationService->sendUpdateNotification(
            $result['title'],
            $result['body'],
            $user,
            $result['route'],
            'name',
            'admin'
        );
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $result = $this->userService->getTextDeleteNotification($user);

        $this->userService->deleteProfile($user);

        $this->notificationService->sendDeleteNotification(
            $result['title'],
            $result['body'],
            $result['route'],
            'admin'
        );
    }
}
