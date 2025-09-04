<?php

namespace App\Filament\Clusters\Posts\Resources\CategoryResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Clusters\Posts\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCategories extends ManageRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
