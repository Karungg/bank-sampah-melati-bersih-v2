<?php

namespace App\Observers;

use App\Contracts\NotificationServiceInterface;
use App\Contracts\ReportServiceInterface;
use App\Contracts\TransactionServiceInterface;
use App\Models\Transaction;

class TransactionObserver
{
    public function __construct(
        protected NotificationServiceInterface $notificationService,
        protected TransactionServiceInterface $transactionService,
        protected ReportServiceInterface $reportService
    ) {}
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        if ($transaction->type == 'weighing') {

            $this->reportService->customerWeighingReportSave($transaction);

            $title = 'Transaksi penimbangan berhasil ditambahkan.';
            $body = ' menambahkan transaksi penimbangan nasabah ' . $transaction->customer->full_name;
            $route = 'filament.admin.resources.transactions.index';
        } else {
            $title = 'Transaksi penjualan berhasil ditambahkan.';
            $body = ' menambahkan transaksi penjualan.';
            $route = 'filament.admin.resources.sales.index';
        }

        $this->reportService->transactionReportSave($transaction);

        $this->notificationService->sendSuccessNotification(
            $title,
            auth()->user()->name . $body,
            $transaction,
            $route,
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
