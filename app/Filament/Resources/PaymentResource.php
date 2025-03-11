<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 8;

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $modelLabel = 'Pembayaran Lapak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Jumlah yang belum dibayarkan')
                    ->schema([
                        Forms\Components\TextInput::make('debt')
                            ->readOnly()
                            ->default(function () {
                                $saleBalance = DB::table('company_profiles')->value('sales_balance');
                                $payment = DB::table('payments')->sum('amount');

                                return $saleBalance - $payment;
                            })
                            ->prefix('Rp.')
                            ->label('Total')
                    ]),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Jumlah Pembayaran')
                    ->placeholder('Masukkan Jumlah Pembayaran')
                    ->minValue(0)
                    ->maxValue(fn(Get $get): int => $get('debt'))
                    ->maxLength(12)
                    ->prefix('Rp.')
                    ->columnSpanFull()
                    ->validationMessages([
                        'max_digits' => 'Jumlah pembayaran maksimal 12 digit.',
                        'max' => 'Pembayaran sudah lunas.'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
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
            'index' => Pages\ManagePayments::route('/'),
        ];
    }
}
