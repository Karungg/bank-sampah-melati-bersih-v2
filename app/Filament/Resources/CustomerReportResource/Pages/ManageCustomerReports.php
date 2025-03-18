<?php

namespace App\Filament\Resources\CustomerReportResource\Pages;

use App\Filament\Resources\CustomerReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCustomerReports extends ManageRecords
{
    protected static string $resource = CustomerReportResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
