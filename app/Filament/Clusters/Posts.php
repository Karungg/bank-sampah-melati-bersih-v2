<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Posts extends Cluster
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-newspaper';

    protected static ?int $navigationSort = 2;

    protected static string | \UnitEnum | null $navigationGroup = 'Master';

    protected static ?string $navigationLabel = 'Kegiatan';

    protected static ?string $clusterBreadcrumb = 'Kegiatan';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }
}
