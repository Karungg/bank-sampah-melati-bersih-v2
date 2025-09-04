<?php

namespace App\Filament\Clusters\Posts\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ExportBulkAction;
use App\Filament\Clusters\Posts\Resources\CategoryResource\Pages\ManageCategories;
use App\Filament\Clusters\Posts;
use App\Filament\Clusters\Posts\Resources\CategoryResource\Pages;
use App\Filament\Exports\CategoryExporter;
use App\Models\Category;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';

    protected static ?string $modelLabel = 'Kategori Kegiatan';

    protected static ?string $cluster = Posts::class;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
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
                TextInput::make('slug')
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
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('No')
                    ->searchable()
                    ->rowIndex(),
                TextColumn::make('title')
                    ->searchable()
                    ->label('Judul Kategori')
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->label('Slug'),
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
                ExportBulkAction::make()
                    ->exporter(CategoryExporter::class)
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCategories::route('/'),
        ];
    }
}
