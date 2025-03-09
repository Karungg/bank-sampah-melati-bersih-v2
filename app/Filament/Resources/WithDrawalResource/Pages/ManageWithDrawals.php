<?php

namespace App\Filament\Resources\WithDrawalResource\Pages;

use App\Contracts\WithDrawalServerInterface;
use App\Filament\Resources\WithDrawalResource;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;

class ManageWithDrawals extends ManageRecords
{
    protected static string $resource = WithDrawalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->before(function (CreateAction $action, array $data, WithDrawalServerInterface $service) {
                    if (!$service->store($data['customer_id'], $data['amount'])) {
                        Notification::make()
                            ->warning()
                            ->title('Tarik uang gagal')
                            ->body('Terjadi kesalahan saat memproses. Silahkan coba lagi nanti.')
                            ->send();

                        $action->halt();
                    };
                }),
        ];
    }
}
