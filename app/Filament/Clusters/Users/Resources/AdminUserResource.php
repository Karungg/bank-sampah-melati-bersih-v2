<?php

namespace App\Filament\Clusters\Users\Resources;

use App\Filament\Clusters\Users;
use App\Filament\Clusters\Users\Resources\AdminUserResource\Pages;
use App\Filament\Clusters\Users\Resources\AdminUserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdminUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    protected static ?string $cluster = Users::class;

    protected static ?string $modelLabel = 'Admin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxValue(255)
                    ->label('Nama')
                    ->validationMessages([
                        'required' => 'Nama harus diisi.',
                        'max' => 'Nama tidak boleh lebih dari 255 karakter.'
                    ]),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->maxValue(255)
                    ->unique(ignoreRecord: true)
                    ->email()
                    ->validationMessages([
                        'required' => 'Email harus diisi.',
                        'max' => 'Email tidak boleh lebih dari 255 karakter.',
                        'unique' => 'Email sudah digunakan.',
                        'email' => 'Email tidak valid.'
                    ]),
                Forms\Components\TextInput::make('password')
                    ->required()
                    ->password()
                    ->revealable()
                    ->maxValue(255)
                    ->minValue(8)
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
                Tables\Columns\TextColumn::make('id')
                    ->label('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->defaultImageUrl(asset('assets/avatars/default.jpeg'))
                    ->circular()
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->alignCenter(),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn(User $user): bool => $user->id == auth()->id())
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
            'index' => Pages\ManageAdminUsers::route('/'),
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
                'created_at',
                'updated_at'
            ])
            ->whereRelation('roles', 'name', '=', 'admin');
    }
}
