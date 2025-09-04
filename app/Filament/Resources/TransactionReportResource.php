<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use App\Filament\Resources\TransactionReportResource\Pages\ListTransactionReports;
use App\Filament\Resources\TransactionReportResource\Pages\ViewTransactionReport;
use App\Filament\Resources\TransactionReportResource\Pages;
use App\Models\Reports\TransactionReport;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TransactionReportResource extends Resource
{
    protected static ?string $model = TransactionReport::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-clipboard';

    protected static ?int $navigationSort = 10;

    protected static string | \UnitEnum | null $navigationGroup = 'Laporan';

    protected static ?string $modelLabel = 'Laporan Penimbangan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('type', 'weighing')
                    ->orderBy('created_at', 'desc');
            })
            ->columns([
                TextColumn::make('id')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('transaction_code')
                    ->searchable()
                    ->sortable()
                    ->label('Kode Transaksi'),
                TextColumn::make('customer.full_name')
                    ->searchable()
                    ->label('Nasabah')
                    ->limit(20)
                    ->sortable(),
                TextColumn::make('total_quantity')
                    ->numeric()
                    ->sortable()
                    ->label('Jumlah')
                    ->suffix(' Pcs'),
                TextColumn::make('total_weight')
                    ->numeric()
                    ->sortable()
                    ->label('Berat')
                    ->suffix(' Kg'),
                TextColumn::make('total_liter')
                    ->numeric()
                    ->sortable()
                    ->label('Liter')
                    ->suffix(' Liter'),
                TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable()
                    ->label('Total')
                    ->prefix('Rp.'),
                TextColumn::make('location')
                    ->searchable()
                    ->label('Lokasi')
                    ->limit(20)
                    ->sortable(),
                TextColumn::make('user.name')
                    ->searchable()
                    ->label('Penimbang')
                    ->limit(20)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Dibuat Saat')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Diupdate Saat')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->deferLoading()
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransactionReports::route('/'),
            'view' => ViewTransactionReport::route('/{record}'),
        ];
    }
}
