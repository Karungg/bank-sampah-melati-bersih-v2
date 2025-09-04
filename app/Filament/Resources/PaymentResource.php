<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\PaymentResource\Pages\ManagePayments;
use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 8;

    protected static string | \UnitEnum | null $navigationGroup = 'Transaksi';

    protected static ?string $modelLabel = 'Pembayaran Lapak';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Jumlah yang belum dibayarkan')
                    ->schema([
                        TextInput::make('debt')
                            ->readOnly()
                            ->default(function () {
                                $saleBalance = DB::table('company_profiles')->value('sales_balance');
                                $payment = DB::table('payments')->sum('amount');

                                return $saleBalance - $payment;
                            })
                            ->prefix('Rp.')
                            ->label('Total')
                    ]),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('Jumlah Pembayaran')
                    ->placeholder('Masukkan Jumlah Pembayaran')
                    ->minValue(0)
                    ->maxValue(fn(Get $get): ?int => $get('debt'))
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
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('No')
                    ->searchable()
                    ->rowIndex(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable()
                    ->label('Total'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Dibuat Saat'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Diupdate Saat')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePayments::route('/'),
        ];
    }
}
