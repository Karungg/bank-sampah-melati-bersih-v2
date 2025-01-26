<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Contracts\TransactionServiceInterface;
use App\Filament\Resources\TransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected TransactionServiceInterface $transactionService;

    public function __construct()
    {
        $this->transactionService = app(TransactionServiceInterface::class);
    }

    protected static string $resource = TransactionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->transactionService->calculateTransaction($data);
    }
}
