<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfficeResource\Pages;
use App\Models\Office;
use App\Models\Department;
use App\Models\Lga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OfficeResource extends Resource
{
    protected static ?string $model = Office::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Organisation';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Office Name')
                        ->required()
                        ->maxLength(150),

                    Forms\Components\TextInput::make('code')
                        ->label('Office Code')
                        ->maxLength(20)
                        ->unique(Office::class, 'code', ignoreRecord: true),
                ]),

                Forms\Components\Textarea::make('address')
                    ->label('Address')
                    ->rows(2)
                    ->columnSpanFull(),

                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('phone')
                        ->label('Phone')
                        ->tel()
                        ->maxLength(20),

                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(100),
                ]),

                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Select::make('lga_id')
                        ->label('LGA')
                        ->options(Lga::orderBy('name')->pluck('name', 'id'))
                        ->searchable(),

                    Forms\Components\Select::make('department_id')
                        ->label('Department')
                        ->options(Department::orderBy('name')->pluck('name', 'id'))
                        ->searchable(),
                ]),

                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Office Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('address')
                    ->label('Address')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->address),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('department.name')
                    ->label('Department')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department_id')
                    ->label('Department')
                    ->options(Department::orderBy('name')->pluck('name', 'id'))
                    ->searchable(),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
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
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOffices::route('/'),
            'create' => Pages\CreateOffice::route('/create'),
            'edit'   => Pages\EditOffice::route('/{record}/edit'),
        ];
    }
}
