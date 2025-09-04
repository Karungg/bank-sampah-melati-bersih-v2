<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\ProductDisplayResource\Pages\ManageProductDisplays;
use App\Filament\Resources\ProductDisplayResource\Pages;
use App\Models\ProductDisplay;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductDisplayResource extends Resource
{
    protected static ?string $model = ProductDisplay::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?int $navigationSort = 3;

    protected static string | \UnitEnum | null $navigationGroup = 'Master';

    protected static ?string $modelLabel = 'Hasil Olahan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->label('Nama Hasil Olahan')
                    ->placeholder('Masukkan nama hasil olahan')
                    ->maxValue(256)
                    ->validationMessages([
                        'required' => 'Nama Hasil Olahan harus diisi.',
                        'max' => 'Nama Hasil Olahan tidak boleh lebih dari 256 karakter.'
                    ]),
                Textarea::make('description')
                    ->required()
                    ->maxLength(2048)
                    ->autosize()
                    ->placeholder('Masukkan deskripsi')
                    ->label('Deskripsi')
                    ->validationMessages([
                        'required' => 'Deskripsi harus diisi.',
                        'max' => 'Deskripsi tidak boleh lebih dari 2048 karakter.'
                    ]),
                FileUpload::make('image')
                    ->image()
                    ->required()
                    ->maxSize(3072)
                    ->placeholder('Unggah foto')
                    ->label('Foto')
                    ->columnSpanFull()
                    ->directory('product-displays')
                    ->validationMessages([
                        'required' => 'Foto harus diisi.'
                    ]),
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
                TextColumn::make('title')
                    ->searchable()
                    ->label('Nama Hasil Olahan')
                    ->sortable()
                    ->limit(20),
                TextColumn::make('description')
                    ->searchable()
                    ->label('Deskripsi')
                    ->limit(50),
                ImageColumn::make('image')
                    ->label('Foto'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Dibuat Saat')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Diupdate Saat')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProductDisplays::route('/'),
        ];
    }
}
