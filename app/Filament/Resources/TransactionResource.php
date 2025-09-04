<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\TransactionResource\Pages\ListTransactions;
use App\Filament\Resources\TransactionResource\Pages\CreateTransaction;
use App\Filament\Resources\TransactionResource\Pages\ViewTransaction;
use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-scale';

    protected static ?int $navigationSort = 5;

    protected static string | \UnitEnum | null $navigationGroup = 'Transaksi';

    protected static ?string $modelLabel = 'Penimbangan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('transaction_code')
                            ->readOnly()
                            ->label('Kode Transaksi')
                            ->hiddenOn('create'),
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])->schema([
                            Select::make('customer_id')
                                ->options(
                                    DB::table('customers')->pluck('full_name', 'id')
                                )
                                ->label('Nasabah')
                                ->required()
                                ->searchable()
                                ->disabledOn('edit')
                                ->validationMessages([
                                    'required' => 'Nasabah harus diisi.'
                                ]),
                            TextInput::make('user_id')
                                ->label('Penimbang')
                                ->hiddenOn('create'),
                            TextInput::make('location')
                                ->maxLength(255)
                                ->label('Lokasi Penimbangan')
                                ->readOnly()
                                ->hiddenOn('create'),
                            TextInput::make('total_quantity')
                                ->suffix(' Pcs')
                                ->readOnly()
                                ->label('Jumlah')
                                ->hiddenOn('create'),
                            TextInput::make('total_weight')
                                ->suffix(' Kg')
                                ->readOnly()
                                ->label('Berat')
                                ->hiddenOn('create'),
                            TextInput::make('total_liter')
                                ->suffix(' Liter')
                                ->readOnly()
                                ->label('Liter')
                                ->hiddenOn('create'),
                            TextInput::make('total_amount')
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
                                Select::make('product_id')
                                    ->required()
                                    ->label('Kategori Sampah')
                                    ->options(
                                        DB::table('products')->pluck('title', 'id')
                                    )
                                    ->searchable()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (?string $state, Set $set) {
                                        $productId = $state;
                                        $unit = DB::table('products')
                                            ->where('id', $productId)
                                            ->value('unit');

                                        $set('product_unit', $unit);
                                    }),
                                TextInput::make('quantity')
                                    ->required()
                                    ->numeric()
                                    ->label('Jumlah')
                                    ->suffix('Pcs')
                                    ->visible(fn(Get $get, ?string $state): bool => $get('product_unit') == 'pcs'
                                        || $state != null),
                                TextInput::make('weight')
                                    ->required()
                                    ->numeric()
                                    ->label('Berat')
                                    ->suffix('Kg')
                                    ->visible(fn(Get $get, ?string $state): bool => $get('product_unit') == 'kg'
                                        || $state != null),
                                TextInput::make('liter')
                                    ->required()
                                    ->numeric()
                                    ->label('Liter')
                                    ->suffix('Liter')
                                    ->visible(fn(Get $get, ?string $state): bool => $get('product_unit') == 'liter'
                                        || $state != null),
                                TextInput::make('subtotal')
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
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListTransactions::route('/'),
            'create' => CreateTransaction::route('/create'),
            'view' => ViewTransaction::route('/{record}'),
        ];
    }
}
