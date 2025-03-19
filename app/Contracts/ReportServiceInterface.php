<?php

namespace App\Contracts;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\WithDrawal;

interface ReportServiceInterface
{
    public function customerWeighingReportSave(Transaction $transaction): void;

    public function customerWithDrawalReportSave(WithDrawal $withDrawal): void;

    public function transactionReportSave(Transaction $transaction): void;

    public function transactionDetailReportSave(TransactionDetail $transactionDetail): void;
}
