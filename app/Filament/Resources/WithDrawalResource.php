<?php

namespace App\Filament\Resources;

use App\Contracts\WithDrawalServerInterface;
use App\Filament\Resources\WithDrawalResource\Pages;
use App\Models\WithDrawal;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class WithDrawalResource extends Resource
{
    protected static ?string $model = WithDrawal::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $modelLabel = 'Tarik Uang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi rekening')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])
                            ->schema([
                                Forms\Components\TextInput::make('debit')
                                    ->readOnly()
                                    ->label('Debet')
                                    ->prefix('Rp.'),
                                Forms\Components\TextInput::make('credit')
                                    ->readOnly()
                                    ->prefix('Rp.')
                                    ->label('Kredit'),
                                Forms\Components\TextInput::make('balance')
                                    ->readOnly()
                                    ->prefix('Rp.')
                                    ->label('Saldo'),
                                Forms\Components\TextInput::make('balanceUnformatted')
                                    ->readOnly()
                                    ->prefix('Rp.')
                                    ->label('Saldo'),
                            ])
                    ])
                    ->hidden(fn(Get $get): bool => empty($get('customer_id'))),
                Section::make()
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 2
                        ])
                            ->schema([
                                Forms\Components\TextInput::make('with_drawal_code')
                                    ->required()
                                    ->readOnly()
                                    ->label('Kode transaksi')
                                    ->maxValue(16)
                                    ->unique()
                                    ->helperText(
                                        fn(string $context): string
                                        => $context == 'view' ? '' : 'Kode transaksi terisi otomatis.'
                                    )
                                    ->validationMessages([
                                        'required' => 'Kode transaksi harus diisi.',
                                        'unique' => 'Kode transaksi sudah digunakan.',
                                        'max' => 'Kode transaksi tidak boleh lebih dari 16 karakter.'
                                    ]),
                                Forms\Components\Select::make('customer_id')
                                    ->searchable()
                                    ->relationship('customer', 'full_name')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, WithDrawalServerInterface $service, ?string $state): ?string {
                                        if ($state) {
                                            $account = DB::table('accounts')->where('customer_id', $state)
                                                ->first(['debit', 'credit', 'balance']);
                                            $set('debit', number_format($account->debit, 0, ',', '.'));
                                            $set('credit', number_format($account->credit, 0, ',', '.'));
                                            $set('balance', number_format($account->balance, 0, ',', '.'));
                                            $set('balanceUnformatted', $account->balance);
                                        }

                                        return $state ? $set('with_drawal_code', $service->generateCode()) : null;
                                    })
                                    ->label('Nasabah')
                                    ->validationMessages([
                                        'required' => 'Nasabah harus diisi.'
                                    ]),
                                Forms\Components\TextInput::make('amount')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->label('Jumlah tarik')
                                    ->maxLength(10)
                                    ->placeholder('Masukkan jumlah tarik')
                                    ->minValue(1)
                                    ->rules([
                                        fn(Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                            if (($get('balanceUnformatted') - $value) < 5000) {
                                                $fail('Saldo tidak mencukupi.');
                                            }
                                        }
                                    ])
                                    ->validationMessages([
                                        'required' => 'Jumlah tarik harus diisi.',
                                        'numeric' => 'Jumlah tarik harus berupa angka.',
                                        'max_digits' => 'Jumlah tarik tidak boleh lebih dari 10 digit dan dua angka dibelakang koma.',
                                        'min' => 'Jumlah tarik tidak boleh kurang dari 1.',
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
                    ->searchable()
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('with_drawal_code')
                    ->searchable()
                    ->sortable()
                    ->label('Kode Transaksi'),
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->searchable()
                    ->label('Nasabah')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->prefix('Rp.')
                    ->sortable()
                    ->label('Jumlah Tarik'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Dibuat Saat'),
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
            'index' => Pages\ManageWithDrawals::route('/'),
        ];
    }
}
