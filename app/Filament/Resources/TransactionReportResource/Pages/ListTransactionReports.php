<?php

namespace App\Filament\Resources\TransactionReportResource\Pages;

use App\Filament\Resources\TransactionReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactionReports extends ListRecords
{
    protected static string $resource = TransactionReportResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
