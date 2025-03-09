<?php

namespace App\Filament\Resources;

use App\Contracts\WithDrawalServerInterface;
use App\Filament\Resources\WithDrawalResource\Pages;
use App\Models\WithDrawal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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
                Forms\Components\TextInput::make('with_drawal_code')
                    ->required()
                    ->readOnly()
                    ->label('Kode transaksi')
                    ->maxValue(16)
                    ->unique()
                    ->live(onBlur: true)
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
                    ->afterStateUpdated(
                        fn(
                            WithDrawalServerInterface $service,
                            Set $set
                        ): string => $set('with_drawal_code', $service->generateCode())
                    )
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
                    ->validationMessages([
                        'required' => 'Jumlah tarik harus diisi.',
                        'numeric' => 'Jumlah tarik harus berupa angka.',
                        'max_digits' => 'Jumlah tarik tidak boleh lebih dari 10 digit dan dua angka dibelakang koma.',
                        'min' => 'Jumlah tarik tidak boleh kurang dari 1.',
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
                Tables\Columns\TextColumn::make('with_drawal_code')
                    ->searchable()
                    ->sortable()
                    ->label('Kode Transaksi'),
                Tables\Columns\TextColumn::make('customer.full_name')
                    ->searchable()
                    ->label('Nasabah'),
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
