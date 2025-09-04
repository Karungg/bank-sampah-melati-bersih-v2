<?php

namespace App\Filament\Resources;

use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\CustomerReportResource\Pages\ManageCustomerReports;
use App\Filament\Resources\CustomerReportResource\Pages;
use App\Models\Reports\CustomerReport;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class CustomerReportResource extends Resource
{
    protected static ?string $model = CustomerReport::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 9;

    protected static string | \UnitEnum | null $navigationGroup = 'Laporan';

    protected static ?string $modelLabel = 'Laporan Saldo Nasabah';

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('No')
                    ->searchable()
                    ->rowIndex(),
                TextColumn::make('transaction_code')
                    ->label('Kode Transaksi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Jenis Transaksi')
                    ->formatStateUsing(fn(string $state): ?string => $state == 'weighing' ? 'Penimbangan' : 'Tarik Uang')
                    ->sortable(),
                TextColumn::make('customer.full_name')
                    ->label('Nama Nasabah')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('debit')
                    ->label('Debet')
                    ->sortable()
                    ->prefix('Rp.')
                    ->formatStateUsing(fn(string $state): ?string => number_format($state, 0, ',', '.')),
                TextColumn::make('credit')
                    ->label('Kredit')
                    ->sortable()
                    ->prefix('Rp.')
                    ->formatStateUsing(fn(string $state): ?string => number_format($state, 0, ',', '.')),
                TextColumn::make('balance')
                    ->label('Saldo')
                    ->sortable()
                    ->prefix('Rp.')
                    ->formatStateUsing(fn(string $state): ?string => number_format($state, 0, ',', '.')),
            ])
            ->deferLoading()
            ->filters([
                //
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCustomerReports::route('/'),
        ];
    }
}
