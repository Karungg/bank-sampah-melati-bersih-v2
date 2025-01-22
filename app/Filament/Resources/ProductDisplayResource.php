<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductDisplayResource\Pages;
use App\Filament\Resources\ProductDisplayResource\RelationManagers;
use App\Models\ProductDisplay;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductDisplayResource extends Resource
{
    protected static ?string $model = ProductDisplay::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $modelLabel = 'Hasil Olahan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('Nama Hasil Olahan')
                    ->maxValue(256)
                    ->validationMessages([
                        'required' => 'Nama Hasil Olahan harus diisi.',
                        'max' => 'Nama Hasil Olahan tidak boleh lebih dari 256 karakter.'
                    ]),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(2048)
                    ->label('Deskripsi')
                    ->validationMessages([
                        'required' => 'Deskripsi harus diisi.',
                        'max' => 'Deskripsi tidak boleh lebih dari 2048 karakter.'
                    ]),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required()
                    ->label('Foto')
                    ->directory('product-displays')
                    ->validationMessages([
                        'required' => 'Foto harus diisi.'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Nama Hasil Olahan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->label('Deskripsi')
                    ->limit(50),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Dibuat Saat')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Diupdate Saat')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProductDisplays::route('/'),
        ];
    }
}
