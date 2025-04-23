<?php

namespace App\Livewire;

use App\Models\Reports\TransactionReport;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class WeighingTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TransactionReport::query()
                    ->where('type', 'weighing')
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                TextColumn::make('id')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('transaction_code')
                    ->searchable()
                    ->sortable()
                    ->label('Kode Transaksi'),
                TextColumn::make('customer.full_name')
                    ->searchable()
                    ->label('Nasabah')
                    ->limit(20)
                    ->sortable(),
                TextColumn::make('total_quantity')
                    ->numeric()
                    ->sortable()
                    ->label('Jumlah')
                    ->suffix(' Pcs'),
                TextColumn::make('total_weight')
                    ->numeric()
                    ->sortable()
                    ->label('Berat')
                    ->suffix(' Kg'),
                TextColumn::make('total_liter')
                    ->numeric()
                    ->sortable()
                    ->label('Liter')
                    ->suffix(' Liter'),
                TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable()
                    ->label('Total')
                    ->prefix('Rp.'),
                TextColumn::make('location')
                    ->searchable()
                    ->label('Lokasi')
                    ->limit(20)
                    ->sortable(),
                TextColumn::make('user.name')
                    ->searchable()
                    ->label('Penimbang')
                    ->limit(20)
                    ->sortable(),
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
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.weighing-table');
    }
}
