<?php

namespace App\Filament\Clusters\Users\Resources\CustomerResource\Pages;

use App\Contracts\CustomerServiceInterface;
use App\Filament\Clusters\Users\Resources\CustomerResource;
use App\Models\User;
use Exception;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateCustomer extends CreateRecord
{
    protected CustomerServiceInterface $customerService;
    protected static string $resource = CustomerResource::class;

    public function __construct()
    {
        $this->customerService = app(CustomerServiceInterface::class);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->customerService->saveUser($data);
    }
}
