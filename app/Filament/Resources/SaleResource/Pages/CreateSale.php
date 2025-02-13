<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Contracts\TransactionServiceInterface;
use App\Filament\Resources\SaleResource;
use App\Filament\Widgets\WeightedProduct;
use Filament\Resources\Pages\CreateRecord;

class CreateSale extends CreateRecord
{
    protected TransactionServiceInterface $transactionService;
    protected $products;

    public function __construct()
    {
        $this->transactionService = app(TransactionServiceInterface::class);
    }

    protected static string $resource = SaleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->products = $data['transactionDetails'];

        return $this->transactionService->calculateTransaction($data, 'sale');
    }

    protected function afterCreate(): void
    {
        $this->transactionService->saveTransactionDetails($this->record->id, $this->products, 'sale');
    }

    protected function getFooterWidgets(): array
    {
        return [
            WeightedProduct::class
        ];
    }
}
