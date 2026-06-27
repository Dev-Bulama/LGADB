<?php

namespace App\Filament\Widgets;

use App\Models\Worker;
use App\Models\Department;
use App\Enums\WorkerStatus;
use App\Enums\VerificationStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalWorkers     = Worker::count();
        $activeWorkers    = Worker::where('status', WorkerStatus::Active)->count();
        $verifiedWorkers  = Worker::where('verification_status', VerificationStatus::Approved)->count();
        $pendingWorkers   = Worker::where('verification_status', VerificationStatus::Pending)->count();
        $suspendedWorkers = Worker::where('status', WorkerStatus::Suspended)->count();
        $totalDepartments = Department::where('is_active', true)->count();

        return [
            Stat::make('Total Workers', $totalWorkers)
                ->description('All registered workers')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary')
                ->chart([$totalWorkers]),

            Stat::make('Active Staff', $activeWorkers)
                ->description('Currently active employees')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Verified Workers', $verifiedWorkers)
                ->description('Identity verified')
                ->descriptionIcon('heroicon-o-shield-check')
                ->color('success'),

            Stat::make('Pending Verification', $pendingWorkers)
                ->description('Awaiting identity check')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Suspended Workers', $suspendedWorkers)
                ->description('Currently suspended')
                ->descriptionIcon('heroicon-o-no-symbol')
                ->color('danger'),

            Stat::make('Active Departments', $totalDepartments)
                ->description('Operational departments')
                ->descriptionIcon('heroicon-o-building-office-2')
                ->color('info'),
        ];
    }
}
