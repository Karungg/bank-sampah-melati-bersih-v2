<?php

namespace App\Observers;

use App\Contracts\ReportServiceInterface;
use App\Models\TransactionDetail;

class TransactionDetailObserver
{
    public function __construct(protected ReportServiceInterface $reportService) {}
    /**
     * Handle the TransactionDetail "created" event.
     */
    public function created(TransactionDetail $transactionDetail): void
    {
        $this->reportService->transactionDetailReportSave($transactionDetail);
    }
}
