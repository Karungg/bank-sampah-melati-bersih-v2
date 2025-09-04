<?php

namespace App\Filament\Clusters\Posts\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ExportBulkAction;
use App\Filament\Clusters\Posts\Resources\PostResource\Pages\ListPosts;
use App\Filament\Clusters\Posts\Resources\PostResource\Pages\CreatePost;
use App\Filament\Clusters\Posts\Resources\PostResource\Pages\ViewPost;
use App\Filament\Clusters\Posts\Resources\PostResource\Pages\EditPost;
use App\Filament\Clusters\Posts;
use App\Filament\Clusters\Posts\Resources\PostResource\Pages;
use App\Filament\Exports\PostExporter;
use App\Models\Post;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $modelLabel = 'Kegiatan';

    protected static ?string $cluster = Posts::class;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxValue(256)
                                    ->label('Judul')
                                    ->placeholder('Masukkan judul')
                                    ->live(onBlur: true)
                                    ->unique(ignoreRecord: true)
                                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                    ->validationMessages([
                                        'required' => 'Judul harus diisi.',
                                        'max' => 'Judul tidak boleh lebih dari 256 karakter.',
                                        'unique' => 'Judul sudah digunakan.'
                                    ]),
                                TextInput::make('slug')
                                    ->required()
                                    ->maxValue(300)
                                    ->label('Slug')
                                    ->readOnly()
                                    ->unique(ignoreRecord: true)
                                    ->helperText(fn(string $context) => $context != 'view' ? 'Slug terisi otomatis setelah mengisi judul' : '')
                                    ->validationMessages([
                                        'required' => 'Slug harus diisi.',
                                        'max' => 'Slug tidak boleh lebih dari 300 karakter.',
                                        'unique' => 'Slug sudah digunakan.'
                                    ]),
                                Select::make('categories')
                                    ->required()
                                    ->label('Kategori')
                                    ->relationship(titleAttribute: 'title')
                                    ->multiple()
                                    ->validationMessages([
                                        'required' => 'Kategori harus diisi.'
                                    ]),
                                TextInput::make('link')
                                    ->maxValue(256)
                                    ->placeholder('Masukkan link')
                                    ->nullable()
                                    ->validationMessages([
                                        'max' => 'Link tidak boleh lebih dari 256 karakter.'
                                    ]),
                                Toggle::make('active')
                                    ->required()
                                    ->label('Status')
                                    ->validationMessages([
                                        'required' => 'Status harus diisi.'
                                    ]),
                            ])
                    ]),
                Section::make()
                    ->schema([
                        RichEditor::make('body')
                            ->required()
                            ->columnSpanFull()
                            ->label('Isi')
                            ->placeholder('Masukkan isi kegiatan')
                            ->maxLength(5000)
                            ->validationMessages([
                                'required' => 'Isi kegiatan tidak boleh kosong.',
                                'max' => 'Isi tidak boleh lebih dari 5000 karakter'
                            ]),
                        FileUpload::make('images')
                            ->required()
                            ->label('Foto')
                            ->image()
                            ->maxSize(3072)
                            ->maxFiles(5)
                            ->minFiles(1)
                            ->imageEditor()
                            ->placeholder('Unggah foto kegiatan')
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
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('No')
                    ->searchable()
                    ->rowIndex(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Judul')
                    ->limit(20),
                TextColumn::make('slug')
                    ->searchable()
                    ->label('Slug')
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('active')
                    ->boolean()
                    ->label('Status')
                    ->sortable(),
                TextColumn::make('link')
                    ->searchable()
                    ->limit(20),
                TextColumn::make('user.name')
                    ->searchable()
                    ->label('Pembuat')
                    ->sortable()
                    ->limit(20),
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
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()
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
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'view' => ViewPost::route('/{record}'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
