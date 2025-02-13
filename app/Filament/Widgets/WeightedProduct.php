<?php

namespace App\Filament\Widgets;

use App\Models\WeightedProduct as ModelsWeightedProduct;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Model;

class WeightedProduct extends TableWidget
{
    use InteractsWithRecord;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ModelsWeightedProduct::query()
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
                    ->label('Satuan'),
                TextColumn::make('product.price')
                    ->searchable()
                    ->label('Harga')
                    ->prefix(' Rp.'),
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
