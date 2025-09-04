<?php

namespace App\Filament\Resources\ProductDisplayResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\ProductDisplayResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProductDisplays extends ManageRecords
{
    protected static string $resource = ProductDisplayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
