<?php

namespace App\Filament\Resources\TransactionSaleReportResource\Pages;

use App\Filament\Resources\TransactionSaleReport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactionReports extends ListRecords
{
    protected static string $resource = TransactionSaleReport::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
