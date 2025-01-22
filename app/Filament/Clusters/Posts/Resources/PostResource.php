<?php

namespace App\Filament\Clusters\Posts\Resources;

use App\Filament\Clusters\Posts;
use App\Filament\Clusters\Posts\Resources\PostResource\Pages;
use App\Filament\Clusters\Posts\Resources\PostResource\RelationManagers;
use App\Filament\Exports\PostExporter;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $modelLabel = 'Kegiatan';

    protected static ?string $cluster = Posts::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxValue(256)
                                    ->label('Judul')
                                    ->live(onBlur: true)
                                    ->unique(ignoreRecord: true)
                                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                    ->validationMessages([
                                        'required' => 'Judul harus diisi.',
                                        'max' => 'Judul tidak boleh lebih dari 256 karakter.',
                                        'unique' => 'Judul sudah digunakan.'
                                    ]),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxValue(300)
                                    ->label('Slug')
                                    ->readOnly()
                                    ->unique(ignoreRecord: true)
                                    ->helperText(fn(string $context) => $context != 'view' ? 'Slug terisi otomatis' : '')
                                    ->validationMessages([
                                        'required' => 'Slug harus diisi.',
                                        'max' => 'Slug tidak boleh lebih dari 300 karakter.',
                                        'unique' => 'Slug sudah digunakan.'
                                    ]),
                                Forms\Components\Select::make('categories')
                                    ->required()
                                    ->label('Kategori')
                                    ->relationship(titleAttribute: 'title')
                                    ->multiple()
                                    ->validationMessages([
                                        'required' => 'Kategori harus diisi.'
                                    ]),
                                Forms\Components\TextInput::make('link')
                                    ->maxValue(256)
                                    ->nullable()
                                    ->validationMessages([
                                        'max' => 'Link tidak boleh lebih dari 256 karakter.'
                                    ]),
                                Forms\Components\Toggle::make('active')
                                    ->required()
                                    ->label('Status')
                                    ->validationMessages([
                                        'required' => 'Status harus diisi.'
                                    ]),
                            ])
                    ]),
                Section::make()
                    ->schema([
                        Forms\Components\RichEditor::make('body')
                            ->required()
                            ->columnSpanFull()
                            ->label('Isi')
                            ->maxLength(5000)
                            ->validationMessages([
                                'required' => 'Isi kegiatan tidak boleh kosong.',
                                'max' => 'Isi tidak boleh lebih dari 5000 karakter'
                            ]),
                        Forms\Components\FileUpload::make('images')
                            ->required()
                            ->label('Foto')
                            ->image()
                            ->multiple()
                            ->directory('posts')
                            ->validationMessages([
                                'required' => 'Foto harus diisi.'
                            ]),
                    ])
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
                    ->sortable()
                    ->label('Judul'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->label('Slug')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('active')
                    ->boolean()
                    ->label('Status')
                    ->sortable(),
                Tables\Columns\TextColumn::make('link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Pembuat')
                    ->sortable(),
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
                Tables\Actions\ExportBulkAction::make()
                    ->exporter(PostExporter::class)
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
