<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Livewire\DatabaseNotifications;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
