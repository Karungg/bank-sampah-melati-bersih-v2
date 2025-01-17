<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeFill(): void
    {
        $this->record->deleted_at != null ? redirect(route('filament.admin.resources.products.index')) : '';
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['price'] = substr($data['price'], 0, -3);

        return $data;
    }
}
