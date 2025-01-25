<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $modelLabel = 'Penimbangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('transaction_code')
                    ->required()
                    ->maxLength(16),
                Forms\Components\TextInput::make('total_quantity')
                    ->numeric(),
                Forms\Components\TextInput::make('total_weight')
                    ->numeric(),
                Forms\Components\TextInput::make('total_liter')
                    ->numeric(),
                Forms\Components\TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'id'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('transaction_code')
                    ->searchable()
                    ->sortable()
                    ->label('Kode Transaksi'),
                Tables\Columns\TextColumn::make('total_quantity')
                    ->numeric()
                    ->sortable()
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('total_weight')
                    ->numeric()
                    ->sortable()
                    ->label('Berat'),
                Tables\Columns\TextColumn::make('total_liter')
                    ->numeric()
                    ->sortable()
                    ->label('Liter'),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable()
                    ->label('Total'),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->label('Lokasi')
                    ->limit(20),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Penimbang')
                    ->limit(20),
                Tables\Columns\TextColumn::make('customer.id')
                    ->searchable()
                    ->label('Nasabah')
                    ->limit(20),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Dibuat Saat')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Diupdate Saat')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
