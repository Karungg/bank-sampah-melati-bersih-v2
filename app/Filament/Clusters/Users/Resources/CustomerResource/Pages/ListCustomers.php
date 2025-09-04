<?php

namespace App\Filament\Clusters\Users\Resources\CustomerResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Clusters\Users\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
