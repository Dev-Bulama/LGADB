<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VerificationLogResource\Pages;
use App\Models\VerificationLog;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VerificationLogResource extends Resource
{
    protected static ?string $model = VerificationLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Verification Logs';

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('worker.full_name')
                    ->label('Worker')
                    ->searchable(['workers.surname', 'workers.first_name'])
                    ->sortable()
                    ->placeholder('Unknown'),

                Tables\Columns\TextColumn::make('worker.staff_number')
                    ->label('Staff No.')
                    ->fontFamily('mono')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('search_query')
                    ->label('Query')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->search_query),

                Tables\Columns\TextColumn::make('search_type')
                    ->label('Search Type')
                    ->badge()
                    ->color('info'),

                Tables\Columns\IconColumn::make('result_found')
                    ->label('Found')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->fontFamily('mono')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Searched At')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('result_found')
                    ->label('Result Found'),

                Tables\Filters\SelectFilter::make('search_type')
                    ->options([
                        'staff_number'      => 'Staff Number',
                        'email'             => 'Email',
                        'phone'             => 'Phone',
                        'national_id'       => 'National ID',
                        'verification_code' => 'Verification Code',
                        'surname'           => 'Surname',
                        'full_name'         => 'Full Name',
                    ]),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')->label('From'),
                        \Filament\Forms\Components\DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('created_at', '<=', $data['until']));
                    }),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('60s');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::whereDate('created_at', today())->count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Verifications today';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVerificationLogs::route('/'),
        ];
    }
}
