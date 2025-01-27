<?php

namespace App\Observers;

use App\Contracts\NotificationServiceInterface;
use App\Models\Account;

class AccountObserver
{
    public function __construct(protected NotificationServiceInterface $notificationService) {}
    /**
     * Handle the Account "created" event.
     */
    public function created(Account $account): void
    {
        $this->notificationService->sendSuccessNotification(
            'Rekening berhasil ditambahkan.',
            auth()->user()->name . ' menambahkan rekening atas nama ' . $account->customer->full_name,
            $account,
            'filament.admin.resources.accounts.index',
            'account_number',
            'adminManagement'
        );
    }

    /**
     * Handle the Account "deleted" event.
     */
    public function deleted(Account $account): void
    {
        $this->notificationService->sendDeleteNotification(
            'Rekening berhasil dihapus.',
            auth()->user()->name . ' menghapus rekening atas nama ' . $account->customer->full_name,
            'filament.admin.resources.accounts.index',
            'adminManagement'
        );
    }
}
