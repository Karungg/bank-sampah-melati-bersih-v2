<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class SaleResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $modelLabel = 'Penjualan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('transaction_code')
                            ->readOnly()
                            ->label('Kode Transaksi'),
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])->schema([
                            Forms\Components\TextInput::make('user_id')
                                ->label('Penjual'),
                            Forms\Components\TextInput::make('total_quantity')
                                ->suffix(' Pcs')
                                ->readOnly()
                                ->label('Jumlah'),
                            Forms\Components\TextInput::make('total_weight')
                                ->suffix(' Kg')
                                ->readOnly()
                                ->label('Berat'),
                            Forms\Components\TextInput::make('total_liter')
                                ->suffix(' Liter')
                                ->readOnly()
                                ->label('Liter'),
                            Forms\Components\TextInput::make('total_amount')
                                ->prefix('Rp.')
                                ->readOnly()
                                ->label('Total'),
                        ])
                    ])->hiddenOn('create'),
                Section::make()
                    ->schema([
                        Repeater::make('transactionDetails')
                            ->label('Sampah')
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->required()
                                    ->label('Kategori Sampah')
                                    ->options(
                                        DB::table('products')
                                            ->join('weighted_products', 'products.id', 'weighted_products.product_id')
                                            ->whereAny([
                                                'weighted_products.total_quantity',
                                                'weighted_products.total_weight',
                                                'weighted_products.total_liter',
                                            ], '>', 0)
                                            ->pluck('products.title', 'products.id')
                                    )
                                    ->searchable()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (?string $state, Set $set, Get $get) {
                                        $productId = $state;
                                        $product = DB::table('products')
                                            ->join('weighted_products', 'products.id', 'weighted_products.product_id')
                                            ->where('products.id', $productId);

                                        $set('product_unit', $product->value('unit'));

                                        if ($get('product_unit') == 'pcs') {
                                            $set('weighted_product', $product->value('total_quantity'));
                                        } elseif ($get('product_unit') == 'kg') {
                                            $set('weighted_product', $product->value('total_weight'));
                                        } elseif ($get('product_unit') == 'liter') {
                                            $set('weighted_product', $product->value('total_liter'));
                                        }
                                    }),
                                Forms\Components\TextInput::make('quantity')
                                    ->required()
                                    ->numeric()
                                    ->label('Jumlah')
                                    ->suffix('Pcs')
                                    ->hint(function (Get $get) {
                                        return new HtmlString('<strong>Terkumpul ' . $get('weighted_product') . ' Pcs</strong>');
                                    })
                                    ->hintColor('primary')
                                    ->placeholder('Masukkan jumlah yang ingin dijual.')
                                    ->visible(fn(Get $get, ?string $state): bool => $get('product_unit') == 'pcs'
                                        || $state != null)
                                    ->maxValue(fn(Get $get): ?string => $get('weighted_product'))
                                    ->validationMessages([
                                        'max' => 'Jumlah tidak boleh lebih dari sampah yang terkumpul'
                                    ]),
                                Forms\Components\TextInput::make('weight')
                                    ->required()
                                    ->numeric()
                                    ->label('Berat')
                                    ->suffix('Kg')
                                    ->hint(function (Get $get) {
                                        return new HtmlString('<strong>Terkumpul ' . $get('weighted_product') . ' Kg</strong>');
                                    })
                                    ->hintColor('primary')
                                    ->placeholder('Masukkan berat yang ingin dijual.')
                                    ->visible(fn(Get $get, ?string $state): bool => $get('product_unit') == 'kg'
                                        || $state != null)
                                    ->maxValue(fn(Get $get): ?string => $get('weighted_product'))
                                    ->validationMessages([
                                        'max' => 'Jumlah tidak boleh lebih dari sampah yang terkumpul'
                                    ]),
                                Forms\Components\TextInput::make('liter')
                                    ->required()
                                    ->numeric()
                                    ->label('Liter')
                                    ->suffix('Liter')
                                    ->hint(function (Get $get) {
                                        return new HtmlString('<strong>Terkumpul ' . $get('weighted_product') . ' Liter</strong>');
                                    })
                                    ->hintColor('primary')
                                    ->placeholder('Masukkan liter yang ingin dijual.')
                                    ->visible(fn(Get $get, ?string $state): bool => $get('product_unit') == 'liter'
                                        || $state != null)
                                    ->maxValue(fn(Get $get): ?string => $get('weighted_product'))
                                    ->validationMessages([
                                        'max' => 'Jumlah tidak boleh lebih dari sampah yang terkumpul'
                                    ]),
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
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('type', 'sale')
                    ->orderBy('created_at', 'desc');
            })
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
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Penjual')
                    ->limit(20)
                    ->sortable(),
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'view' => Pages\ViewSale::route('/{record}'),
        ];
    }
}
