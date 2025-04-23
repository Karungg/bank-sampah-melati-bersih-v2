<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class IncomeStatement extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    protected static ?int $navigationSort = 12;

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?string $title = 'Laporan Laba Rugi';

    protected static string $view = 'filament.pages.income-statement';
}
