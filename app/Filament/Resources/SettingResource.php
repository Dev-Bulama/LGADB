<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('key')
                        ->label('Key')
                        ->required()
                        ->maxLength(150)
                        ->unique(Setting::class, 'key', ignoreRecord: true)
                        ->helperText('Use snake_case format, e.g. site_name'),

                    Forms\Components\TextInput::make('group')
                        ->label('Group')
                        ->maxLength(100)
                        ->default('general')
                        ->helperText('Logical grouping, e.g. general, mail, payment'),
                ]),

                Forms\Components\Textarea::make('value')
                    ->label('Value')
                    ->rows(4)
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->rows(2)
                    ->columnSpanFull()
                    ->helperText('Describe what this setting controls'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Key')
                    ->searchable()
                    ->sortable()
                    ->fontFamily('mono')
                    ->copyable(),

                Tables\Columns\TextColumn::make('group')
                    ->label('Group')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('value')
                    ->label('Value')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->value)
                    ->placeholder('(empty)'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(60)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options(fn () => Setting::distinct()->pluck('group', 'group')->filter()->toArray())
                    ->label('Group'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('group');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit'   => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
