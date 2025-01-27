<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Contracts\AccountServiceInterface;
use App\Filament\Resources\AccountResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAccount extends CreateRecord
{
    protected AccountServiceInterface $accountService;

    public function __construct()
    {
        $this->accountService = app(AccountServiceInterface::class);
    }

    protected static string $resource = AccountResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['account_number'] = $this->accountService->generateAccountNumber($data['customer_id']);

        return $data;
    }
}
