<?php

namespace App\Filament\Resources;

use App\Contracts\ProductServiceInterface;
use App\Filament\Exports\ProductExporter;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $modelLabel = 'Kategori Sampah';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('product_code')
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
                                'max' => 'Kode Kategori tidak boleh lebih dari 16 karakter',
                                'unique' => 'Kode Kategori sudah digunakan.'
                            ]),
                        Grid::make([
                            'default' => 1,
                            'md' => 2
                        ])
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxValue(100)
                                    ->label('Nama Kategori')
                                    ->live(onBlur: true)
                                    ->unique(ignoreRecord: true)
                                    ->afterStateUpdated(function (Set $set, ?string $state, ProductServiceInterface $service): string {
                                        return $set('product_code', $service->generateCode($state));
                                    })
                                    ->validationMessages([
                                        'required' => 'Nama Kategori harus diisi.',
                                        'max' => 'Nama Kategori tidak boleh melebihi 100 karakter.',
                                        'unique' => 'Nama Kategori sudah digunakan.'
                                    ]),
                                Forms\Components\Textarea::make('description')
                                    ->maxLength(1000)
                                    ->label('Deskripsi'),
                                Forms\Components\Select::make('unit')
                                    ->required()
                                    ->label('Satuan')
                                    ->options([
                                        'kg' => 'Kg',
                                        'liter' => 'Liter',
                                        'pcs' => 'Pcs'
                                    ])
                                    ->validationMessages([
                                        'required' => 'Satuan harus diisi.'
                                    ]),
                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->label('Harga')
                                    ->maxLength(10)
                                    ->minValue(1)
                                    ->validationMessages([
                                        'required' => 'Harga harus diisi.',
                                        'numeric' => 'Harga harus berupa angka.',
                                        'max_digits' => 'Harga tidak boleh melebihi 10 digit dan dua angka dibelakang koma',
                                        'min' => 'Harga tidak boleh kurang dari 1',
                                    ]),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('product_code')
                    ->searchable()
                    ->label('Kode Kategori'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Nama Kategori')
                    ->sortable()
                    ->limit(20),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->label('Deskripsi')
                    ->limit(20),
                Tables\Columns\TextColumn::make('unit')
                    ->searchable()
                    ->label('Satuan')
                    ->sortable()
                    ->formatStateUsing(fn(string $state) => ucfirst($state)),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable()
                    ->label('Harga'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Dibuat Saat'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Diupdate Saat'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Dihapus Saat'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
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
