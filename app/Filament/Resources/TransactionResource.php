<?php

namespace App\Filament\Resources;

use App\Contracts\TransactionServiceInterface as Service;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

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
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('transaction_code')
                            ->readOnly()
                            ->label('Kode Transaksi')
                            ->hiddenOn('create'),
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])->schema([
                            Forms\Components\Select::make('customer_id')
                                ->options(
                                    DB::table('customers')->pluck('full_name', 'id')
                                )
                                ->label('Nasabah')
                                ->searchable()
                                ->disabledOn('edit'),
                            Forms\Components\TextInput::make('user_id')
                                ->label('Penimbang')
                                ->hiddenOn('create'),
                            Forms\Components\TextInput::make('location')
                                ->maxLength(255)
                                ->label('Lokasi Penimbangan')
                                ->readOnly()
                                ->hiddenOn('create'),
                            Forms\Components\TextInput::make('total_quantity')
                                ->suffix(' Pcs')
                                ->readOnly()
                                ->label('Jumlah')
                                ->hiddenOn('create'),
                            Forms\Components\TextInput::make('total_weight')
                                ->suffix(' Kg')
                                ->readOnly()
                                ->label('Berat')
                                ->hiddenOn('create'),
                            Forms\Components\TextInput::make('total_liter')
                                ->suffix(' Liter')
                                ->readOnly()
                                ->label('Liter')
                                ->hiddenOn('create'),
                            Forms\Components\TextInput::make('total_amount')
                                ->prefix('Rp.')
                                ->readOnly()
                                ->label('Total')
                                ->hiddenOn('create'),
                        ])
                    ]),
                Section::make()
                    ->schema([
                        Repeater::make('transactionDetails')
                            ->label('Sampah')
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->required()
                                    ->label('Kategori Sampah')
                                    ->options(
                                        DB::table('products')->pluck('title', 'id')
                                    )
                                    ->searchable()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->live(onBlur: true),
                                Forms\Components\TextInput::make('quantity')
                                    ->required()
                                    ->numeric()
                                    ->label('Jumlah')
                                    ->suffix(' Pcs')
                                    ->hidden(function (Get $get, Service $service): bool {
                                        return
                                            $get('product_id') === null
                                            || $service->unitCheck('pcs', $get('product_id'));
                                    }),
                                Forms\Components\TextInput::make('weight')
                                    ->required()
                                    ->numeric()
                                    ->label('Berat')
                                    ->suffix(' Kg')
                                    ->hidden(function (Get $get, Service $service): bool {
                                        return
                                            $get('product_id') === null
                                            || $service->unitCheck('kg', $get('product_id'));
                                    }),
                                Forms\Components\TextInput::make('liter')
                                    ->required()
                                    ->numeric()
                                    ->label('Liter')
                                    ->suffix(' Liter')
                                    ->hidden(function (Get $get, Service $service): bool {
                                        return
                                            $get('product_id') === null
                                            || $service->unitCheck('liter', $get('product_id'));
                                    }),
                                Forms\Components\TextInput::make('subtotal')
                                    ->required()
                                    ->numeric()
                                    ->label('Subtotal')
                                    ->prefix('Rp.')
                                    ->columnSpanFull()
                                    ->hidden(fn(?string $state): bool => $state == null),
                            ])->reorderable(false)
                            ->minItems(1)
                            ->columns(2)
                            ->itemLabel(function (array $state, $component) {
                                $key = array_search($state, $component->getState());
                                $index = array_search($key, array_keys($component->getState()));

                                return 'Sampah ke-' . $index + 1;
                            })
                    ])
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
                    ->label('Jumlah')
                    ->suffix(' Pcs'),
                Tables\Columns\TextColumn::make('total_weight')
                    ->numeric()
                    ->sortable()
                    ->label('Berat')
                    ->suffix(' Kg'),
                Tables\Columns\TextColumn::make('total_liter')
                    ->numeric()
                    ->sortable()
                    ->label('Liter')
                    ->suffix(' Liter'),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable()
                    ->label('Total')
                    ->prefix('Rp.'),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->label('Lokasi')
                    ->limit(20),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Penimbang')
                    ->limit(20),
                Tables\Columns\TextColumn::make('customer.full_name')
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
