<?php

namespace App\Filament\Clusters\Users\Resources\CustomerResource\Pages;

use App\Filament\Clusters\Users\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
