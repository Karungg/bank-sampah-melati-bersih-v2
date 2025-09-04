<?php

namespace App\Filament\Clusters\Posts\Resources\PostResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Clusters\Posts\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
