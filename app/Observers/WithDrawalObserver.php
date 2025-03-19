<?php

namespace App\Observers;

use App\Contracts\NotificationServiceInterface;
use App\Contracts\ReportServiceInterface;
use App\Contracts\WithDrawalServerInterface;
use App\Models\WithDrawal;

class WithDrawalObserver
{
    public function __construct(
        protected NotificationServiceInterface $notificationService,
        protected WithDrawalServerInterface $withDrawalService,
        protected ReportServiceInterface $reportService
    ) {}
    /**
     * Handle the WithDrawal "created" event.
     */
    public function created(WithDrawal $withDrawal): void
    {
        $this->reportService->customerWithDrawalReportSave($withDrawal);

        $this->notificationService->sendSuccessNotification(
            'Tarik uang berhasil',
            auth()->user()->name . ' menambahkan transaksi tarik uang nasabah atas nama ' . $withDrawal->customer->full_name . '.',
            $withDrawal,
            'filament.admin.resources.with-drawals.index',
            'full_name',
            'adminManagement'
        );
    }

    /**
     * Handle the WithDrawal "deleted" event.
     */
    public function deleted(WithDrawal $withDrawal): void
    {
        //
    }
}
