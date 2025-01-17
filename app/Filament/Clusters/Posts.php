<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Posts extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationLabel = 'Kegiatan';

    protected static ?string $clusterBreadcrumb = 'Kegiatan';
}
