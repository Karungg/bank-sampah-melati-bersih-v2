<?php

namespace App\Filament\Exports;

use App\Models\Customer;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CustomerExporter extends Exporter
{
    protected static ?string $model = Customer::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nik')
                ->label('NIK'),
            ExportColumn::make('full_name')
                ->label('Nama Lengkap'),
            ExportColumn::make('place_of_birth')
                ->label('Tempat Lahir'),
            ExportColumn::make('date_of_birth')
                ->label('Tanggal Lahir'),
            ExportColumn::make('phone')
                ->label('Nomor Telepon'),
            ExportColumn::make('address')
                ->label('Alamat'),
            ExportColumn::make('rt')
                ->label('RT'),
            ExportColumn::make('rw')
                ->label('RW'),
            ExportColumn::make('village')
                ->label('Desa'),
            ExportColumn::make('district')
                ->label('Kecamatan'),
            ExportColumn::make('city')
                ->label('Kota'),
            ExportColumn::make('postal_code')
                ->label('Kode Pos'),
            ExportColumn::make('created_at')
                ->label('Dibuat Saat'),
            ExportColumn::make('updated_at')
                ->label('Diupdate Saat'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your customer export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public function getFileName(Export $export): string
    {
        return "bsmb-pengguna-nasabah-" . date('d-m-Y') . "({$export->getKey()})";
    }
}
