<?php

namespace App\Filament\Exports;

use App\Models\Product;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProductExporter extends Exporter
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('product_code')
                ->label('Kode Kategori Sampah'),
            ExportColumn::make('title')
                ->label('Nama Kategori'),
            ExportColumn::make('description')
                ->label('Deskripsi'),
            ExportColumn::make('unit')
                ->label('Satuan'),
            ExportColumn::make('price')
                ->label('Harga'),
            ExportColumn::make('created_at')
                ->label('Dibuat Saat'),
            ExportColumn::make('updated_at')
                ->label('Diupdate Saat'),
            ExportColumn::make('deleted_at')
                ->label('Dihapus Saat'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your product export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return "bsmb-kategori-sampah-" . date('d-m-Y') . "({$export->getKey()})";
    }
}
