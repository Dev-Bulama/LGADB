<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\RecentWorkersWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'LGA Workforce Dashboard';

    protected static ?int $navigationSort = -2;

    public function getColumns(): int | string | array
    {
        return 2;
    }

    public function getHeaderWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
        ];
    }

    public function getFooterWidgets(): array
    {
        return [
            RecentWorkersWidget::class,
        ];
    }
}
