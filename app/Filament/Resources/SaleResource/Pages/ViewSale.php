<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Contracts\TransactionServiceInterface;
use App\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\DB;

class ViewSale extends ViewRecord
{
    protected TransactionServiceInterface $transactionService;

    public function __construct()
    {
        $this->transactionService = app(TransactionServiceInterface::class);
    }

    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['user_id'] = DB::table('users')
            ->where('id', $data['user_id'])
            ->value('name');

        $data['transactionDetails'] = DB::table('transaction_details')
            ->join('products', 'transaction_details.product_id', 'products.id')
            ->where('transaction_details.transaction_id', $this->record->id)
            ->get([
                DB::raw('products.title as product_id'),
                'transaction_details.quantity',
                'transaction_details.weight',
                'transaction_details.liter',
                'transaction_details.subtotal'
            ])
            ->map(function ($item) {
                return (array)$item;
            })
            ->toArray();

        return $data;
    }
}
