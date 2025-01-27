<?php

namespace App\Observers;

use App\Contracts\NotificationServiceInterface;
use App\Contracts\TransactionServiceInterface;
use App\Models\Transaction;

class TransactionObserver
{
    public function __construct(
        protected NotificationServiceInterface $notificationService,
        protected TransactionServiceInterface $transactionService
    ) {}
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        $this->notificationService->sendSuccessNotification(
            'Transaksi penimbangan berhasil ditambahkan.',
            auth()->user()->name . ' menambahkan penimbangan nasabah ' . $transaction->customer->full_name,
            $transaction,
            'filament.admin.resources.transactions.index',
            'transaction_code',
            'adminManagement'
        );
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }
}
