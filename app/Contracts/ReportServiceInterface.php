<?php

namespace App\Contracts;

use App\Models\Transaction;

interface ReportServiceInterface
{
    public function customerReportSave(Transaction $transaction): void;
}
