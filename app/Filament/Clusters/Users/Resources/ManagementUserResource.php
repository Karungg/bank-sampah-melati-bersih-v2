<?php

namespace App\Filament\Clusters\Users\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ExportBulkAction;
use App\Filament\Clusters\Users\Resources\ManagementUserResource\Pages\ManageManagementUsers;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use App\Filament\Clusters\Users;
use App\Filament\Clusters\Users\Resources\ManagementUserResource\Pages;
use App\Filament\Exports\ManagementExporter;
use App\Models\User;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ManagementUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user';

    protected static ?string $cluster = Users::class;

    protected static ?string $modelLabel = 'Pengurus';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('avatar_url')
                    ->hidden(
                        fn(string $context) =>
                        $context === 'edit' && auth()->id()
                            !== ($schema->getRecord()->id ?? '')
                    )
                    ->label('Foto Profil')
                    ->maxSize(3072)
                    ->avatar()
                    ->imageEditor()
                    ->directory('avatars')
                    ->nullable()
                    ->placeholder('Unggah foto profil')
                    ->image(),
                TextInput::make('name')
                    ->required()
                    ->maxValue(255)
                    ->label('Nama')
                    ->placeholder('Masukkan nama')
                    ->validationMessages([
                        'required' => 'Nama harus diisi.',
                        'max' => 'Nama tidak boleh lebih dari 255 karakter.'
                    ]),
                TextInput::make('email')
                    ->required()
                    ->maxValue(255)
                    ->unique(ignoreRecord: true)
                    ->email()
                    ->placeholder('Masukkan email')
                    ->validationMessages([
                        'required' => 'Email harus diisi.',
                        'max' => 'Email tidak boleh lebih dari 255 karakter.',
                        'unique' => 'Email sudah digunakan.',
                        'email' => 'Email tidak valid.'
                    ]),
                TextInput::make('password')
                    ->required(fn(string $context): string => $context != 'edit')
                    ->password()
                    ->revealable()
                    ->placeholder('Masukkan password')
                    ->maxValue(255)
                    ->minValue(8)
                    ->helperText(fn(string $context): string => $context == 'edit'
                        ? 'Kosongkan jika tidak diubah'
                        : '')
                    ->validationMessages([
                        'required' => 'Password harus diisi.',
                        'max' => 'Password tidak boleh lebih dari 255 karakter.',
                        'min' => 'Password harus berisi setidaknya 8 karakter.',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama')
                    ->limit(20),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->limit(20),
                ImageColumn::make('avatar_url')
                    ->defaultImageUrl(asset('assets/avatars/default.jpeg'))
                    ->circular()
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->alignCenter()
                    ->label('Foto Profil'),
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
                static::getEditAction(),
                static::getDeleteAction()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    static::getDeleteBulkAction()
                ]),
                ExportBulkAction::make()
                    ->exporter(ManagementExporter::class),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageManagementUsers::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select([
                'id',
                'name',
                'email',
                'avatar_url',
                'password',
                'created_at',
                'updated_at'
            ])
            ->whereRelation('roles', 'name', '=', 'management')
            ->orderBy('created_at', 'desc');
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public static function getEditAction(): EditAction
    {
        return EditAction::make()
            ->mutateDataUsing(function (array $data, $record): array {
                $data['password'] ?? $data['password'] = $record->password;
                return $data;
            });
    }

    public static function getDeleteAction(): Action
    {
        return Action::make('hapus')
            ->hidden(fn(User $user) => $user->id == auth()->id())
            ->requiresConfirmation()
            ->modalHeading('Hapus pengurus')
            ->modalDescription('Apakah anda yakin ingin menghapus pengurus ini? Hal ini tidak dapat dibatalkan.')
            ->modalSubmitActionLabel('Hapus')
            ->icon('heroicon-m-trash')
            ->color('danger')
            ->schema([
                TextInput::make('confirm')
                    ->required()
                    ->label('Ketik "Saya yakin ingin menghapus" untuk konfirmasi.'),
            ])
            ->action(function (array $data, User $record) {
                if ($data['confirm'] !== 'Saya yakin ingin menghapus') {
                    Notification::make()
                        ->title('Konfirmasi tidak sesuai')
                        ->danger()
                        ->send();

                    return;
                }

                $record->delete();

                Notification::make()
                    ->title('Pengguna berhasil dihapus.')
                    ->success()
                    ->send();
            });
    }

    public static function getDeleteBulkAction(): BulkAction
    {
        return BulkAction::make('Hapus pengurus yang dipilih')
            ->requiresConfirmation()
            ->modalHeading('Hapus pengurus yang dipilih')
            ->modalDescription('Apakah anda yakin ingin menghapus pengurus ini? Hal ini tidak dapat dibatalkan.')
            ->modalSubmitActionLabel('Hapus')
            ->icon('heroicon-m-trash')
            ->color('danger')
            ->form([
                TextInput::make('confirm')
                    ->required()
                    ->label('Ketik "Saya yakin ingin menghapus" untuk konfirmasi.'),
            ])
            ->action(function (array $data, Collection $records) {
                if ($data['confirm'] !== 'Saya yakin ingin menghapus') {
                    Notification::make()
                        ->title('Konfirmasi tidak sesuai')
                        ->danger()
                        ->send();

                    return;
                }

                $records->each->delete();

                Notification::make()
                    ->title('Pengurus berhasil dihapus.')
                    ->success()
                    ->send();
            })
            ->deselectRecordsAfterCompletion();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereRelation('roles', 'name', '=', 'management')->count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return "Jumlah pengurus";
    }
}
