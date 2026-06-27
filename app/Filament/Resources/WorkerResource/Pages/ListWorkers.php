<?php

namespace App\Filament\Resources\WorkerResource\Pages;

use App\Filament\Resources\WorkerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use App\Enums\WorkerStatus;
use Illuminate\Database\Eloquent\Builder;

class ListWorkers extends ListRecords
{
    protected static string $resource = WorkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Workers')
                ->icon('heroicon-o-users'),

            'pending' => Tab::make('Pending')
                ->icon('heroicon-o-clock')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', WorkerStatus::Pending))
                ->badge(fn () => static::getResource()::getModel()::where('status', WorkerStatus::Pending)->count()),

            'active' => Tab::make('Active')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', WorkerStatus::Active))
                ->badge(fn () => static::getResource()::getModel()::where('status', WorkerStatus::Active)->count()),

            'suspended' => Tab::make('Suspended')
                ->icon('heroicon-o-no-symbol')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', WorkerStatus::Suspended))
                ->badge(fn () => static::getResource()::getModel()::where('status', WorkerStatus::Suspended)->count()),
        ];
    }
}
