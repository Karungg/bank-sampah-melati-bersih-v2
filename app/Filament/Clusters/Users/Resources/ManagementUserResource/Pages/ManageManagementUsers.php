<?php

namespace App\Filament\Clusters\Users\Resources\ManagementUserResource\Pages;

use App\Filament\Clusters\Users\Resources\ManagementUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageManagementUsers extends ManageRecords
{
    protected static string $resource = ManagementUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
