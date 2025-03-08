<?php

namespace App\Filament\Clusters\Posts\Resources;

use App\Filament\Clusters\Posts;
use App\Filament\Clusters\Posts\Resources\CategoryResource\Pages;
use App\Filament\Exports\CategoryExporter;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $modelLabel = 'Kategori Kegiatan';

    protected static ?string $cluster = Posts::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxValue(256)
                    ->placeholder('Masukkan judul kategori')
                    ->label('Judul Kategori')
                    ->unique(ignoreRecord: true)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->validationMessages([
                        'required' => 'Judul harus diisi.',
                        'max' => 'Judul tidak boleh lebih dari 256 karakter.',
                        'unique' => 'Judul sudah digunakan.'
                    ]),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->helperText('Slug terisi otomatis setelah mengisi judul kategori')
                    ->readOnly()
                    ->maxValue(300)
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'required' => 'Slug harus diisi.',
                        'max' => 'Slug tidak boleh lebih dari 300 karakter.',
                        'unique' => 'Slug sudah digunakan.'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->searchable()
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Judul Kategori')
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->label('Slug'),
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
                Tables\Actions\ExportBulkAction::make()
                    ->exporter(CategoryExporter::class)
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCategories::route('/'),
        ];
    }
}
