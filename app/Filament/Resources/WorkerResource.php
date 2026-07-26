<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkerResource\Pages;
use App\Models\Worker;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Office;
use App\Models\Lga;
use App\Models\State;
use App\Models\Ward;
use App\Enums\WorkerStatus;
use App\Enums\VerificationStatus;
use App\Enums\EmploymentType;
use App\Enums\Gender;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use App\Services\IdCardService;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkerResource extends Resource
{
    protected static ?string $model = Worker::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Citizens';

    protected static ?string $navigationGroup = 'Citizen Registry';

    protected static ?string $modelLabel = 'Citizen';

    protected static ?string $pluralModelLabel = 'Citizens';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Citizen Details')
                ->tabs([

                    // TAB 1: Personal Information
                    Forms\Components\Tabs\Tab::make('Personal Information')
                        ->icon('heroicon-o-user')
                        ->schema([
                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\TextInput::make('surname')
                                    ->label('Surname')
                                    ->required()
                                    ->maxLength(100),

                                Forms\Components\TextInput::make('first_name')
                                    ->label('First Name')
                                    ->required()
                                    ->maxLength(100),

                                Forms\Components\TextInput::make('middle_name')
                                    ->label('Middle Name')
                                    ->maxLength(100),
                            ]),

                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\Select::make('gender')
                                    ->label('Gender')
                                    ->options(Gender::options())
                                    ->required(),

                                Forms\Components\DatePicker::make('date_of_birth')
                                    ->label('Date of Birth')
                                    ->maxDate(now()->subYears(16))
                                    ->native(false),

                                Forms\Components\TextInput::make('blood_group')
                                    ->label('Blood Group')
                                    ->maxLength(5),
                            ]),

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->maxLength(20),

                                Forms\Components\TextInput::make('whatsapp')
                                    ->label('WhatsApp Number')
                                    ->tel()
                                    ->maxLength(20),
                            ]),

                            Forms\Components\Grid::make(1)->schema([
                                Forms\Components\TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->maxLength(255),
                            ]),

                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\TextInput::make('national_id')
                                    ->label('National ID (NIN)')
                                    ->maxLength(50),

                                Forms\Components\TextInput::make('bvn')
                                    ->label('BVN')
                                    ->maxLength(20),

                                Forms\Components\TextInput::make('tax_number')
                                    ->label('Tax Identification Number')
                                    ->maxLength(50),
                            ]),

                            Forms\Components\SpatieMediaLibraryFileUpload::make('profile_photo')
                                ->label('Profile Photo')
                                ->collection('profile_photo')
                                ->image()
                                ->imageEditor()
                                ->maxSize(2048)
                                ->columnSpanFull(),
                        ]),

                    // TAB 2: Address
                    Forms\Components\Tabs\Tab::make('Address')
                        ->icon('heroicon-o-map-pin')
                        ->schema([
                            Forms\Components\Textarea::make('residential_address')
                                ->label('Residential Address')
                                ->rows(3)
                                ->columnSpanFull(),

                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\Select::make('state_id')
                                    ->label('State')
                                    ->options(State::orderBy('name')->pluck('name', 'id'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('lga_id', null);
                                        $set('ward_id', null);
                                    }),

                                Forms\Components\Select::make('lga_id')
                                    ->label('LGA')
                                    ->options(function (Get $get) {
                                        $stateId = $get('state_id');
                                        if (!$stateId) return [];
                                        return Lga::where('state_id', $stateId)->orderBy('name')->pluck('name', 'id');
                                    })
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(fn (Set $set) => $set('ward_id', null)),

                                Forms\Components\Select::make('ward_id')
                                    ->label('Ward')
                                    ->options(function (Get $get) {
                                        $lgaId = $get('lga_id');
                                        if (!$lgaId) return [];
                                        return Ward::where('lga_id', $lgaId)->orderBy('name')->pluck('name', 'id');
                                    })
                                    ->searchable(),
                            ]),
                        ]),

                    // TAB 3: Registration Details
                    Forms\Components\Tabs\Tab::make('Registration Details')
                        ->icon('heroicon-o-identification')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('staff_number')
                                    ->label('Citizen ID')
                                    ->maxLength(50)
                                    ->unique(Worker::class, 'staff_number', ignoreRecord: true),

                                Forms\Components\TextInput::make('designation')
                                    ->label('Occupation / Job Title')
                                    ->maxLength(150),
                            ]),

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\Select::make('employment_type')
                                    ->label('Residency Type')
                                    ->options(EmploymentType::options()),

                                Forms\Components\DatePicker::make('employment_date')
                                    ->label('Registration Date')
                                    ->native(false),
                            ]),

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\Select::make('department_id')
                                    ->label('Category / Group')
                                    ->options(Department::orderBy('name')->pluck('name', 'id'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(fn (Set $set) => $set('unit_id', null)),

                                Forms\Components\Select::make('unit_id')
                                    ->label('Sub-Category')
                                    ->options(function (Get $get) {
                                        $deptId = $get('department_id');
                                        if (!$deptId) return [];
                                        return Unit::where('department_id', $deptId)->orderBy('name')->pluck('name', 'id');
                                    })
                                    ->searchable(),
                            ]),

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('employee_number')
                                    ->label('Reference Number')
                                    ->maxLength(50),

                                Forms\Components\Select::make('office_id')
                                    ->label('Registration Office')
                                    ->options(Office::orderBy('name')->pluck('name', 'id'))
                                    ->searchable(),
                            ]),
                        ]),

                    // TAB 4: Emergency Contact
                    Forms\Components\Tabs\Tab::make('Emergency Contact')
                        ->icon('heroicon-o-user-group')
                        ->schema([
                            Forms\Components\Section::make('Emergency Contact')
                                ->schema([
                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\TextInput::make('emergency_contact_name')
                                            ->label('Contact Name')
                                            ->maxLength(200),

                                        Forms\Components\TextInput::make('emergency_contact_phone')
                                            ->label('Contact Phone')
                                            ->tel()
                                            ->maxLength(20),

                                        Forms\Components\TextInput::make('next_of_kin_relationship')
                                            ->label('Relationship')
                                            ->maxLength(50),
                                    ]),

                                    Forms\Components\Textarea::make('next_of_kin_address')
                                        ->label('Contact Address')
                                        ->rows(2)
                                        ->columnSpanFull(),
                                ]),

                            Forms\Components\Section::make('Next of Kin')
                                ->schema([
                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\TextInput::make('next_of_kin_name')
                                            ->label('Full Name')
                                            ->maxLength(200),

                                        Forms\Components\TextInput::make('next_of_kin_phone')
                                            ->label('Phone Number')
                                            ->tel()
                                            ->maxLength(20),

                                        Forms\Components\DatePicker::make('confirmation_date')
                                            ->label('Date of Next Renewal')
                                            ->native(false),
                                    ]),
                                ]),
                        ]),

                    // TAB 5: Status
                    Forms\Components\Tabs\Tab::make('Status')
                        ->icon('heroicon-o-shield-check')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Citizen Status')
                                    ->options(WorkerStatus::options())
                                    ->default(WorkerStatus::Pending->value)
                                    ->required(),

                                Forms\Components\Select::make('verification_status')
                                    ->label('Verification Status')
                                    ->options(VerificationStatus::options())
                                    ->default(VerificationStatus::Pending->value)
                                    ->required(),
                            ]),

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\DateTimePicker::make('verified_at')
                                    ->label('Verified At')
                                    ->native(false),

                                Forms\Components\DatePicker::make('id_expiry_date')
                                    ->label('ID Card Expiry Date')
                                    ->native(false),
                            ]),

                            Forms\Components\Textarea::make('rejection_reason')
                                ->label('Rejection Reason')
                                ->rows(3)
                                ->columnSpanFull(),

                            Forms\Components\Textarea::make('notes')
                                ->label('Internal Notes')
                                ->rows(3)
                                ->columnSpanFull(),
                        ]),

                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('profile_photo')
                    ->label('Photo')
                    ->collection('profile_photo')
                    ->conversion('thumb')
                    ->circular()
                    ->defaultImageUrl(fn () => asset('images/default-avatar.png')),

                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable(['surname', 'first_name', 'middle_name'])
                    ->sortable(query: function (Builder $query, string $direction) {
                        $query->orderBy('surname', $direction)->orderBy('first_name', $direction);
                    })
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('staff_number')
                    ->label('Citizen ID')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono'),

                Tables\Columns\TextColumn::make('ward.name')
                    ->label('Ward')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('designation')
                    ->label('Occupation')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->designation),

                Tables\Columns\TextColumn::make('employment_type')
                    ->label('Residency Type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof EmploymentType ? $state->label() : $state)
                    ->color('info'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof WorkerStatus ? $state->label() : $state)
                    ->color(fn ($state) => $state instanceof WorkerStatus ? $state->color() : 'gray'),

                Tables\Columns\TextColumn::make('verification_status')
                    ->label('Verification')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof VerificationStatus ? $state->label() : $state)
                    ->color(fn ($state) => $state instanceof VerificationStatus ? $state->color() : 'gray'),

                Tables\Columns\TextColumn::make('employment_date')
                    ->label('Registered')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(WorkerStatus::options())
                    ->label('Status'),

                Tables\Filters\SelectFilter::make('verification_status')
                    ->options(VerificationStatus::options())
                    ->label('Verification'),

                Tables\Filters\SelectFilter::make('employment_type')
                    ->options(EmploymentType::options())
                    ->label('Employment Type'),

                Tables\Filters\SelectFilter::make('department_id')
                    ->label('Department')
                    ->options(Department::orderBy('name')->pluck('name', 'id'))
                    ->searchable(),

                Tables\Filters\SelectFilter::make('gender')
                    ->options(Gender::options())
                    ->label('Gender'),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('verify')
                    ->label('Verify')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Verify Citizen')
                    ->modalDescription('This will mark the citizen as Active and set their verification status to Approved.')
                    ->action(function (Worker $record) {
                        $record->update([
                            'status' => WorkerStatus::Active,
                            'verification_status' => VerificationStatus::Approved,
                            'verified_at' => now(),
                            'verified_by' => auth()->id(),
                        ]);
                        if ($record->user?->email) {
                            try {
                                $record->user->notify(new \App\Notifications\WorkerVerifiedNotification($record));
                            } catch (\Throwable) {}
                        }
                        Notification::make()
                            ->title('Citizen Verified')
                            ->body("{$record->full_name} has been verified and set to Active.")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Worker $record) => $record->verification_status !== VerificationStatus::Approved),

                Tables\Actions\Action::make('suspend')
                    ->label('Suspend')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Suspend Citizen')
                    ->modalDescription('Are you sure you want to suspend this citizen record?')
                    ->action(function (Worker $record) {
                        $record->update(['status' => WorkerStatus::Suspended]);
                        if ($record->user?->email) {
                            try {
                                $record->user->notify(new \App\Notifications\WorkerSuspendedNotification($record));
                            } catch (\Throwable) {}
                        }
                        Notification::make()
                            ->title('Citizen Suspended')
                            ->body("{$record->full_name} has been suspended.'))
                            ->warning()
                            ->send();
                    })
                    ->visible(fn (Worker $record) => $record->status !== WorkerStatus::Suspended),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->required()
                            ->rows(3)
                            ->placeholder('Explain why this citizen record is being rejected...'),
                    ])
                    ->action(function (Worker $record, array $data) {
                        $record->update([
                            'verification_status' => VerificationStatus::Rejected,
                            'rejection_reason'    => $data['rejection_reason'],
                        ]);
                        if ($record->user?->email) {
                            try {
                                $record->user->notify(new \App\Notifications\WorkerRejectedNotification($record));
                            } catch (\Throwable) {}
                        }
                        Notification::make()
                            ->title('Citizen Rejected')
                            ->body("{$record->full_name}'s record has been rejected.")
                            ->danger()
                            ->send();
                    })
                    ->visible(fn (Worker $record) => $record->verification_status !== VerificationStatus::Rejected),

                Tables\Actions\Action::make('generate_id')
                    ->label('Generate ID')
                    ->icon('heroicon-o-identification')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Generate ID Card')
                    ->modalDescription('Generate a PDF Resident ID card for this citizen?')
                    ->action(function (Worker $record) {
                        try {
                            (new IdCardService())->generate($record);
                            Notification::make()
                                ->title('ID Card Generated')
                                ->body("ID card has been generated for {$record->full_name}.")
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('ID Card generation failed')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn (Worker $record) => $record->verification_status === VerificationStatus::Approved),

                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_csv')
                    ->label('Export CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->action(function () {
                        $filename = 'citizens-' . now()->format('Y-m-d') . '.csv';
                        $headers  = [
                            'Content-Type'        => 'text/csv',
                            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                        ];
                        $workers = Worker::with(['department', 'unit', 'office'])
                            ->orderBy('surname')->get();

                        $callback = function () use ($workers) {
                            $handle = fopen('php://output', 'w');
                            fputcsv($handle, [
                                'Citizen ID', 'Surname', 'First Name', 'Middle Name',
                                'Gender', 'Date of Birth', 'Email', 'Phone',
                                'Category', 'Sub-Category', 'Office', 'Occupation',
                                'Residency Type', 'Registration Date',
                                'Status', 'Verification Status', 'LGA', 'Ward',
                            ]);
                            foreach ($workers as $w) {
                                fputcsv($handle, [
                                    $w->staff_number, $w->surname, $w->first_name, $w->middle_name,
                                    $w->gender?->value, $w->date_of_birth?->format('Y-m-d'), $w->email, $w->phone,
                                    $w->department?->name, $w->unit?->name, $w->office?->name, $w->designation,
                                    $w->grade_level, $w->step, $w->employment_type?->value, $w->employment_date?->format('Y-m-d'),
                                    $w->status?->value, $w->verification_status?->value, $w->lga?->name,
                                ]);
                            }
                            fclose($handle);
                        };
                        return response()->stream($callback, 200, $headers);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Personal Information')
                ->icon('heroicon-o-user')
                ->columns(3)
                ->schema([
                    Infolists\Components\SpatieMediaLibraryImageEntry::make('profile_photo')
                        ->label('Photo')
                        ->collection('profile_photo')
                        ->conversion('medium')
                        ->circular()
                        ->columnSpan(1),

                    Infolists\Components\Group::make([
                        Infolists\Components\TextEntry::make('full_name')
                            ->label('Full Name')
                            ->weight('bold')
                            ->size('lg'),

                        Infolists\Components\TextEntry::make('gender')
                            ->label('Gender')
                            ->formatStateUsing(fn ($state) => $state instanceof Gender ? $state->label() : $state),

                        Infolists\Components\TextEntry::make('date_of_birth')
                            ->label('Date of Birth')
                            ->date('d F Y'),

                        Infolists\Components\TextEntry::make('blood_group')
                            ->label('Blood Group'),
                    ])->columnSpan(2),
                ]),

            Infolists\Components\Section::make('Contact Information')
                ->icon('heroicon-o-phone')
                ->columns(3)
                ->schema([
                    Infolists\Components\TextEntry::make('phone')
                        ->label('Phone'),

                    Infolists\Components\TextEntry::make('whatsapp')
                        ->label('WhatsApp'),

                    Infolists\Components\TextEntry::make('email')
                        ->label('Email')
                        ->copyable(),

                    Infolists\Components\TextEntry::make('national_id')
                        ->label('National ID (NIN)'),

                    Infolists\Components\TextEntry::make('bvn')
                        ->label('BVN'),

                    Infolists\Components\TextEntry::make('tax_number')
                        ->label('Tax Number'),
                ]),

            Infolists\Components\Section::make('Address')
                ->icon('heroicon-o-map-pin')
                ->columns(3)
                ->schema([
                    Infolists\Components\TextEntry::make('residential_address')
                        ->label('Residential Address')
                        ->columnSpanFull(),

                    Infolists\Components\TextEntry::make('state.name')
                        ->label('State'),

                    Infolists\Components\TextEntry::make('lga.name')
                        ->label('LGA'),

                    Infolists\Components\TextEntry::make('ward.name')
                        ->label('Ward'),
                ]),

            Infolists\Components\Section::make('Registration Details')
                ->icon('heroicon-o-identification')
                ->columns(3)
                ->schema([
                    Infolists\Components\TextEntry::make('staff_number')
                        ->label('Citizen ID')
                        ->copyable()
                        ->fontFamily('mono'),

                    Infolists\Components\TextEntry::make('employee_number')
                        ->label('Reference Number'),

                    Infolists\Components\TextEntry::make('designation')
                        ->label('Occupation'),

                    Infolists\Components\TextEntry::make('department.name')
                        ->label('Category / Group'),

                    Infolists\Components\TextEntry::make('unit.name')
                        ->label('Sub-Category'),

                    Infolists\Components\TextEntry::make('office.name')
                        ->label('Registration Office'),

                    Infolists\Components\TextEntry::make('employment_type')
                        ->label('Residency Type')
                        ->badge()
                        ->formatStateUsing(fn ($state) => $state instanceof EmploymentType ? $state->label() : $state)
                        ->color('info'),

                    Infolists\Components\TextEntry::make('employment_date')
                        ->label('Registration Date')
                        ->date('d F Y'),

                    Infolists\Components\TextEntry::make('confirmation_date')
                        ->label('Renewal Date')
                        ->date('d F Y'),
                ]),

            Infolists\Components\Section::make('Emergency Contact')
                ->icon('heroicon-o-user-group')
                ->columns(2)
                ->schema([
                    Infolists\Components\TextEntry::make('emergency_contact_name')
                        ->label('Contact Name'),

                    Infolists\Components\TextEntry::make('emergency_contact_phone')
                        ->label('Contact Phone'),

                    Infolists\Components\TextEntry::make('next_of_kin_name')
                        ->label('Next of Kin Name'),

                    Infolists\Components\TextEntry::make('next_of_kin_phone')
                        ->label('Next of Kin Phone'),

                    Infolists\Components\TextEntry::make('next_of_kin_relationship')
                        ->label('Relationship'),

                    Infolists\Components\TextEntry::make('next_of_kin_address')
                        ->label('Contact Address')
                        ->columnSpanFull(),
                ]),

            Infolists\Components\Section::make('Status & Verification')
                ->icon('heroicon-o-shield-check')
                ->columns(3)
                ->schema([
                    Infolists\Components\TextEntry::make('status')
                        ->label('Status')
                        ->badge()
                        ->formatStateUsing(fn ($state) => $state instanceof WorkerStatus ? $state->label() : $state)
                        ->color(fn ($state) => $state instanceof WorkerStatus ? $state->color() : 'gray'),

                    Infolists\Components\TextEntry::make('verification_status')
                        ->label('Verification Status')
                        ->badge()
                        ->formatStateUsing(fn ($state) => $state instanceof VerificationStatus ? $state->label() : $state)
                        ->color(fn ($state) => $state instanceof VerificationStatus ? $state->color() : 'gray'),

                    Infolists\Components\TextEntry::make('verified_at')
                        ->label('Verified At')
                        ->dateTime('d M Y H:i'),

                    Infolists\Components\TextEntry::make('id_expiry_date')
                        ->label('ID Expiry Date')
                        ->date('d F Y'),

                    Infolists\Components\TextEntry::make('verification_code')
                        ->label('Verification Code')
                        ->copyable()
                        ->fontFamily('mono'),

                    Infolists\Components\TextEntry::make('id_card_generated_at')
                        ->label('ID Card Generated')
                        ->dateTime('d M Y H:i'),

                    Infolists\Components\TextEntry::make('rejection_reason')
                        ->label('Rejection Reason')
                        ->columnSpanFull(),

                    Infolists\Components\TextEntry::make('notes')
                        ->label('Notes')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListWorkers::route('/'),
            'create' => Pages\CreateWorker::route('/create'),
            'view'   => Pages\ViewWorker::route('/{record}'),
            'edit'   => Pages\EditWorker::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }
}
