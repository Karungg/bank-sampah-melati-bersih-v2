<?php

namespace App\Filament\Clusters\Users\Resources\AdminUserResource\Pages;

use App\Filament\Clusters\Users\Resources\AdminUserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAdminUsers extends ManageRecords
{
    protected static string $resource = AdminUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->after(function (User $user) {
                    $user->assignRole('admin');
                }),
        ];
    }
}
