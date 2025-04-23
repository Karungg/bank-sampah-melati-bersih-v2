<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class IncomeStatement extends BaseWidget
{
    protected function getStats(): array
    {
        $weighing = DB::table('transaction_reports')->where('type', 'weighing')->sum('total_amount');
        $sale = DB::table('transaction_reports')->where('type', 'sale')->sum('total_amount');
        $income = $weighing - $sale;

        return [
            Stat::make('Total Penimbangan', 'Rp.' . number_format($weighing, 0, ',', '.')),
            Stat::make('Total Penjualan', 'Rp.' . number_format($sale, 0, ',', '.')),
            Stat::make('Laba/Rugi', 'Rp.' . number_format($income, 0, ',', '.')),
        ];
    }
}
