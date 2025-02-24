<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\WeightedProduct;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class WeightedProductsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                WeightedProduct::query()
                    ->with(['product:id,title,unit,price'])
                    ->where('total_quantity', '>=', 0)
                    ->where('total_weight', '>=', 0)
                    ->where('total_liter', '>=', 0)
            )
            ->columns([
                TextColumn::make('id')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('product.title')
                    ->searchable()
                    ->label('Nama Sampah'),
                TextColumn::make('product.unit')
                    ->searchable()
                    ->label('Satuan')
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                TextColumn::make('product.price')
                    ->searchable()
                    ->label('Harga')
                    ->prefix(' Rp.')
                    ->formatStateUsing(fn(string $state): string => number_format($state, 0, ',', '.')),
                TextColumn::make('total_quantity')
                    ->searchable()
                    ->label('Jumlah Terkumpul')
                    ->sortable()
                    ->suffix(' Pcs'),
                TextColumn::make('total_weight')
                    ->searchable()
                    ->label('Berat Terkumpul')
                    ->sortable()
                    ->suffix(' Kg'),
                TextColumn::make('total_liter')
                    ->searchable()
                    ->label('Liter Terkumpul')
                    ->sortable()
                    ->suffix(' Liter'),
            ])
            ->defaultPaginationPageOption(5)
            ->heading('Sampah Terkumpul');
    }
}
