<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\AccountResource\Pages\ListAccounts;
use App\Filament\Resources\AccountResource\Pages\CreateAccount;
use App\Filament\Resources\AccountResource\Pages\ViewAccount;
use App\Filament\Resources\AccountResource\Pages;
use App\Models\Account;
use App\Models\Customer;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 4;

    protected static string | \UnitEnum | null $navigationGroup = 'Master';

    protected static ?string $modelLabel = 'Rekening';

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
                                Select::make('customer_id')
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
                                TextInput::make('debit')
                                    ->required()
                                    ->numeric()
                                    ->placeholder('Masukkan debit')
                                    ->default(0.00)
                                    ->minValue(0)
                                    ->label('Debet')
                                    ->maxLength(12)
                                    ->prefix('Rp.')
                                    ->validationMessages([
                                        'max_digits' => 'Debit maksimal 12 digit.'
                                    ]),
                                TextInput::make('credit')
                                    ->required()
                                    ->numeric()
                                    ->default(0.00)
                                    ->minValue(0)
                                    ->placeholder('Masukkan kredit')
                                    ->label('Kredit')
                                    ->maxLength(12)
                                    ->prefix('Rp.')
                                    ->validationMessages([
                                        'max_digits' => 'Kredit maksimal 12 digit.'
                                    ]),
                                TextInput::make('balance')
                                    ->required()
                                    ->numeric()
                                    ->default(0.00)
                                    ->label('Saldo')
                                    ->placeholder('Masukkan saldo')
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
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('account_number')
                    ->searchable()
                    ->label('Nomor Rekening'),
                TextColumn::make('customer.full_name')
                    ->searchable()
                    ->label('Nasabah')
                    ->limit(30),
                TextColumn::make('debit')
                    ->numeric()
                    ->sortable()
                    ->label('Debet')
                    ->prefix('Rp.'),
                TextColumn::make('credit')
                    ->numeric()
                    ->sortable()
                    ->label('Kredit')
                    ->prefix('Rp.'),
                TextColumn::make('balance')
                    ->numeric()
                    ->sortable()
                    ->label('Saldo')
                    ->prefix('Rp.'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Dibuat Saat')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Diupdate Saat')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->deferLoading()
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAccounts::route('/'),
            'create' => CreateAccount::route('/create'),
            'view' => ViewAccount::route('/{record}'),
        ];
    }
}
