<?php

namespace App\Filament\Widgets;

use App\Models\CompanyProfile;
use App\Models\Transaction;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Database\Eloquent\Builder;

class StatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    public function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        return [
            StatsOverviewWidget\Stat::make(
                label: 'Total pendapatan penimbangan',
                value: 'Rp.' . number_format(
                    Transaction::query()
                        ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                        ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                        ->where('type', 'weighing')
                        ->sum('total_amount'),
                    0,
                    ',',
                    '.'
                ),
            )->description($startDate ? "Dimulai dari $startDate" : ""),
            StatsOverviewWidget\Stat::make(
                label: 'Total pendapatan penjualan',
                value: 'Rp.' . number_format(
                    Transaction::query()
                        ->when($startDate, fn(Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                        ->when($endDate, fn(Builder $query) => $query->whereDate('created_at', '<=', $endDate))
                        ->where('type', 'sale')
                        ->sum('total_amount'),
                    0,
                    ',',
                    '.'
                ),
            )->description($endDate ? "Hingga $endDate" : ""),
            StatsOverviewWidget\Stat::make(
                label: 'Saldo bank',
                value: 'Rp.' . number_format(
                    CompanyProfile::query()
                        ->value('balance'),
                    0,
                    ',',
                    '.'
                ),
            ),
        ];
    }
}
