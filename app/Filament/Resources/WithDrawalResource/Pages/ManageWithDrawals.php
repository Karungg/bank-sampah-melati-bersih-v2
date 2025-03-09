<?php

namespace App\Filament\Resources\WithDrawalResource\Pages;

use App\Filament\Resources\WithDrawalResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageWithDrawals extends ManageRecords
{
    protected static string $resource = WithDrawalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
