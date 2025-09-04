<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Users extends Cluster
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;

    protected static string | \UnitEnum | null $navigationGroup = 'Master';

    protected static ?string $navigationLabel = 'Pengguna';

    protected static ?string $clusterBreadcrumb = 'Pengguna';
}
