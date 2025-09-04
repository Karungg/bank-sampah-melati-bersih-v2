<?php

namespace App\Filament\Clusters\Users\Resources\CustomerResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Clusters\Users\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\DB;

class ViewCustomer extends ViewRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $customer = DB::table('users')
            ->where('id', $data['user_id'])
            ->first(['email', 'avatar_url']);

        $data['email'] = $customer->email;
        $data['avatar_url'] = $customer->avatar_url;

        return $data;
    }
}
