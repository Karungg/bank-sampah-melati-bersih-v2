<?php

namespace App\Filament\Clusters\Users\Resources\CustomerResource\Pages;

use App\Contracts\CustomerServiceInterface;
use App\Filament\Clusters\Users\Resources\CustomerResource;
use App\Models\User;
use Exception;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EditCustomer extends EditRecord
{
    protected CustomerServiceInterface $customerService;

    protected static string $resource = CustomerResource::class;

    public function __construct()
    {
        $this->customerService = app(CustomerServiceInterface::class);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
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

    protected function mutateFormDataBeforeSave(array $data): array {
        return $this->customerService->editUser($data);
    }
}
