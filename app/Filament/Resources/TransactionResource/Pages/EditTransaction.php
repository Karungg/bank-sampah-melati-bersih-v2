<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['user_id'] = DB::table('users')
            ->where('id', $data['user_id'])
            ->value('name');

        $data['transactionDetails'] = DB::table('transaction_details')
            ->where('transaction_id', $this->record->id)
            ->get(['product_id', 'quantity', 'weight', 'liter', 'subtotal'])
            ->map(function ($item) {
                return (array)$item;
            })
            ->toArray();

        return $data;
    }
}
