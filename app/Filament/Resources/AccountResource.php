<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Models\Account;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $modelLabel = 'Rekening';

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
                                Forms\Components\Select::make('customer_id')
                                    ->options(
                                        Customer::doesntHave('account')->pluck('full_name', 'id')
                                    )
                                    ->required()
                                    ->label('Nasabah')
                                    ->searchable()
                                    ->disabledOn('edit')
                                    ->validationMessages([
                                        'required' => 'Nasabah harus diisi.'
                                    ]),
                                Forms\Components\TextInput::make('debit')
                                    ->required()
                                    ->numeric()
                                    ->default(0.00)
                                    ->minValue(0)
                                    ->label('Debet')
                                    ->maxLength(12)
                                    ->prefix('Rp.')
                                    ->validationMessages([
                                        'max_digits' => 'Debit maksimal 12 digit.'
                                    ]),
                                Forms\Components\TextInput::make('credit')
                                    ->required()
                                    ->numeric()
                                    ->default(0.00)
                                    ->minValue(0)
                                    ->label('Kredit')
                                    ->maxLength(12)
                                    ->prefix('Rp.')
                                    ->validationMessages([
                                        'max_digits' => 'Kredit maksimal 12 digit.'
                                    ]),
                                Forms\Components\TextInput::make('balance')
                                    ->required()
                                    ->numeric()
                                    ->default(0.00)
                                    ->label('Saldo')
                                    ->minValue(0)
                                    ->maxLength(12)
                                    ->prefix('Rp.')
                                    ->validationMessages([
                                        'max_digits' => 'Saldo maksimal 12 digit.'
                                    ]),
                            ])
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
                Tables\Columns\TextColumn::make('account_number')
                    ->searchable()
                    ->label('Nomor Rekening'),
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->searchable()
                    ->label('Nasabah')
                    ->limit(30),
                Tables\Columns\TextColumn::make('debit')
                    ->numeric()
                    ->sortable()
                    ->label('Debet')
                    ->prefix('Rp.'),
                Tables\Columns\TextColumn::make('credit')
                    ->numeric()
                    ->sortable()
                    ->label('Kredit')
                    ->prefix('Rp.'),
                Tables\Columns\TextColumn::make('balance')
                    ->numeric()
                    ->sortable()
                    ->label('Saldo')
                    ->prefix('Rp.'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Dibuat Saat')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Diupdate Saat')
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'view' => Pages\ViewAccount::route('/{record}'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
