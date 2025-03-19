<?php

namespace App\Filament\Resources\TransactionSaleReportResource\Pages;

use App\Filament\Resources\TransactionSaleReport;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTransactionReport extends ViewRecord
{
    protected static string $resource = TransactionSaleReport::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
