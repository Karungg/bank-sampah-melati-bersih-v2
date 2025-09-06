<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ExportBulkAction;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\Pages\ViewProduct;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Contracts\ProductServiceInterface;
use App\Filament\Exports\ProductExporter;
use App\Models\Product;
use Closure;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 0;

    protected static string | \UnitEnum | null $navigationGroup = 'Master';

    protected static ?string $modelLabel = 'Kategori Sampah';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('product_code')
                            ->required()
                            ->maxValue(16)
                            ->label('Kode Kategori')
                            ->helperText(
                                fn(string $context): string
                                => $context == 'view' ? '' : 'Kode Kategori terisi otomatis.'
                            )
                            ->readOnly()
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'required' => 'Kode Kategori harus terisi.',
                                'max' => 'Kode Kategori tidak boleh lebih dari 16 karakter.',
                                'unique' => 'Kode Kategori sudah digunakan.'
                            ]),
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxValue(100)
                                    ->label('Nama Kategori')
                                    ->live(onBlur: true)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('Masukkan nama kategori')
                                    ->afterStateUpdated(function (Set $set, ?string $state, ProductServiceInterface $service): ?string {
                                        return $state ? $set('product_code', $service->generateCode($state)) : null;
                                    })
                                    ->validationMessages([
                                        'required' => 'Nama Kategori harus diisi.',
                                        'max' => 'Nama Kategori tidak boleh lebih dari 100 karakter.',
                                        'unique' => 'Nama Kategori sudah digunakan.'
                                    ]),
                                Textarea::make('description')
                                    ->label('Deskripsi')
                                    ->autosize()
                                    ->placeholder('Masukkan deskripsi kategori')
                                    ->rules([
                                        fn(): Closure => function (string $attribute, $value, Closure $fail) {
                                            if (strlen($value) > 1000) {
                                                $fail('Deskripsi tidak boleh lebih dari 1000 karakter.');
                                            }
                                        }
                                    ]),
                                ToggleButtons::make('unit')
                                    ->required()
                                    ->label('Satuan')
                                    ->options([
                                        'kg' => 'Kg',
                                        'liter' => 'Liter',
                                        'pcs' => 'Pcs'
                                    ])
                                    ->inline()
                                    ->validationMessages([
                                        'required' => 'Satuan harus diisi.'
                                    ]),
                                TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->label('Harga')
                                    ->maxLength(10)
                                    ->placeholder('Masukkan harga')
                                    ->minValue(1)
                                    ->mask(RawJs::make('$money($input, \',\')'))
                                    ->stripCharacters('.')
                                    ->validationMessages([
                                        'required' => 'Harga harus diisi.',
                                        'numeric' => 'Harga harus berupa angka.',
                                        'max_digits' => 'Harga tidak boleh lebih dari 10 digit dan dua angka dibelakang koma.',
                                        'min' => 'Harga tidak boleh kurang dari 1.',
                                    ]),
                                DateTimePicker::make('created_at')
                                    ->readOnly()
                                    ->label('Dibuat Saat')
                                    ->hiddenOn(['edit', 'create']),
                                DateTimePicker::make('updated_at')
                                    ->readOnly()
                                    ->label('Diupdate Saat')
                                    ->hiddenOn(['edit', 'create']),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('product_code')
                    ->searchable()
                    ->label('Kode Kategori'),
                TextColumn::make('title')
                    ->searchable()
                    ->label('Nama Kategori')
                    ->sortable()
                    ->limit(20),
                TextColumn::make('description')
                    ->searchable()
                    ->label('Deskripsi')
                    ->limit(20),
                TextColumn::make('unit')
                    ->searchable()
                    ->label('Satuan')
                    ->sortable()
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                TextColumn::make('price')
                    ->sortable()
                    ->label('Harga')
                    ->formatStateUsing(fn(string $state): string => number_format($state, 0, ',', '.'))
                    ->prefix('Rp'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Dibuat Saat'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Diupdate Saat'),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Dihapus Saat'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
                ExportBulkAction::make()
                    ->exporter(ProductExporter::class),
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'view' => ViewProduct::route('/{record}'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasRole('admin');
    }
}
