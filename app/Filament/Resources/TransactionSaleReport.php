<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionSaleReportResource\Pages;
use App\Models\Reports\TransactionReport;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionSaleReport extends Resource
{
    protected static ?string $model = TransactionReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    protected static ?int $navigationSort = 11;

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $modelLabel = 'Laporan Penjualan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListTransactionReports::route('/'),
            'view' => Pages\ViewTransactionReport::route('/{record}'),
        ];
    }
}
