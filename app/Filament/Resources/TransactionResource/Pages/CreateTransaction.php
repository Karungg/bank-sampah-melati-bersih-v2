<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Contracts\TransactionServiceInterface;
use App\Filament\Resources\TransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected TransactionServiceInterface $transactionService;
    protected $products;

    public function __construct()
    {
        $this->transactionService = app(TransactionServiceInterface::class);
    }

    protected static string $resource = TransactionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->products = $data['transactionDetails'];

        return $this->transactionService->calculateTransaction($data);
    }

    protected function afterCreate(): void
    {
        $this->transactionService->saveTransactionDetails($this->record->id, $this->products);
    }
}
