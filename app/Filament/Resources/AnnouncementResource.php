<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, ?string $state) {
                            $set('slug', Str::slug($state ?? ''));
                        }),

                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(Announcement::class, 'slug', ignoreRecord: true),
                ]),

                Forms\Components\Select::make('type')
                    ->label('Type')
                    ->options([
                        'news'         => 'News',
                        'announcement' => 'Announcement',
                        'career'       => 'Career',
                        'download'     => 'Download',
                    ])
                    ->required()
                    ->default('announcement'),

                Forms\Components\Textarea::make('excerpt')
                    ->label('Excerpt')
                    ->rows(2)
                    ->maxLength(500)
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('content')
                    ->label('Content')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'h2', 'h3',
                        'bulletList', 'orderedList',
                        'link',
                        'blockquote',
                        'undo', 'redo',
                    ])
                    ->columnSpanFull(),

                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Toggle::make('is_published')
                        ->label('Published')
                        ->default(false)
                        ->live(),

                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Publish Date')
                        ->native(false)
                        ->visible(fn (Forms\Get $get) => $get('is_published')),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(60)
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'news'         => 'info',
                        'announcement' => 'warning',
                        'career'       => 'success',
                        'download'     => 'gray',
                        default        => 'primary',
                    })
                    ->formatStateUsing(fn (string $state) => ucfirst($state)),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published At')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('Not scheduled'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'news'         => 'News',
                        'announcement' => 'Announcement',
                        'career'       => 'Career',
                        'download'     => 'Download',
                    ]),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published'),
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit'   => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
