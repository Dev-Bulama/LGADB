<?php

namespace App\Filament\Widgets;

use App\Models\Worker;
use App\Enums\WorkerStatus;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentWorkersWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Recently Registered Citizens';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Worker::latest()->limit(5)
            )
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('profile_photo')
                    ->label('Photo')
                    ->collection('profile_photo')
                    ->conversion('thumb')
                    ->circular()
                    ->defaultImageUrl(fn () => asset('images/default-avatar.png')),

                Tables\Columns\TextColumn::make('full_name')
                    ->label('Name')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('staff_number')
                    ->label('Citizen ID')
                    ->fontFamily('mono'),

                Tables\Columns\TextColumn::make('department.name')
                    ->label('Department')
                    ->placeholder('Unassigned'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof WorkerStatus ? $state->label() : $state)
                    ->color(fn ($state) => $state instanceof WorkerStatus ? $state->color() : 'gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Worker $record) => \App\Filament\Resources\WorkerResource::getUrl('view', ['record' => $record])),
            ])
            ->paginated(false);
    }
}
