<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerReportResource\Pages;
use App\Models\Reports\CustomerReport;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class CustomerReportResource extends Resource
{
    protected static ?string $model = CustomerReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $modelLabel = 'Laporan Saldo Nasabah';

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->searchable()
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('transaction_code')
                    ->label('Kode Transaksi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis Transaksi')
                    ->formatStateUsing(fn(string $state): ?string => $state == 'weighing' ? 'Penimbangan' : 'Tarik Uang')
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->label('Nama Nasabah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('debit')
                    ->label('Debet')
                    ->sortable()
                    ->prefix('Rp.')
                    ->formatStateUsing(fn(string $state): ?string => number_format($state, 0, ',', '.')),
                Tables\Columns\TextColumn::make('credit')
                    ->label('Kredit')
                    ->sortable()
                    ->prefix('Rp.')
                    ->formatStateUsing(fn(string $state): ?string => number_format($state, 0, ',', '.')),
                Tables\Columns\TextColumn::make('balance')
                    ->label('Saldo')
                    ->sortable()
                    ->prefix('Rp.')
                    ->formatStateUsing(fn(string $state): ?string => number_format($state, 0, ',', '.')),
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCustomerReports::route('/'),
        ];
    }
}
