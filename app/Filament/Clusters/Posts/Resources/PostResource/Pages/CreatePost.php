<?php

namespace App\Filament\Clusters\Posts\Resources\PostResource\Pages;

use App\Filament\Clusters\Posts\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
}
