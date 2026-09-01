<?php

namespace App\Models;

use App\Enums\EmploymentType;
use App\Enums\Gender;
use App\Enums\VerificationStatus;
use App\Enums\WorkerStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Worker extends Model implements HasMedia
{
    use SoftDeletes, HasUuids, InteractsWithMedia, LogsActivity;

    protected $fillable = [
        'uuid',
        'user_id',
        'surname',
        'first_name',
        'middle_name',
        'gender',
        'date_of_birth',
        'phone',
        'whatsapp',
        'email',
        'national_id',
        'bvn',
        'tax_number',
        'residential_address',
        'state_name',
        'lga_name',
        'state_id',
        'lga_id',
        'ward_id',
        'department_id',
        'unit_id',
        'office_id',
        'designation',
        'grade_level',
        'step',
        'salary_category',
        'employment_type',
        'employment_date',
        'confirmation_date',
        'employee_number',
        'staff_number',
        'status',
        'verification_status',
        'verification_code',
        'verification_hash',
        'verified_at',
        'verified_by',
        'supervisor_id',
        'blood_group',
        'id_card_generated_at',
        'id_expiry_date',
        'next_of_kin_name',
        'next_of_kin_phone',
        'next_of_kin_relationship',
        'next_of_kin_address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'qualifications',
        'certifications',
        'skills',
        'languages',
        'notes',
        'rejection_reason',
    ];

    protected $appends = [
        'full_name',
        'age',
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'gender' => Gender::class,
            'employment_type' => EmploymentType::class,
            'status' => WorkerStatus::class,
            'verification_status' => VerificationStatus::class,
            'date_of_birth' => 'date',
            'employment_date' => 'date',
            'confirmation_date' => 'date',
            'id_expiry_date' => 'date',
            'verified_at' => 'datetime',
            'id_card_generated_at' => 'datetime',
            'qualifications' => 'array',
            'certifications' => 'array',
            'skills' => 'array',
            'languages' => 'array',
        ];
    }

    // Override uniqueIds to specify the uuid column
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    protected static function booted(): void
    {
        static::creating(function (Worker $worker) {
            if (empty($worker->staff_number)) {
                $worker->staff_number = static::generateStaffNumber();
            }
            if (empty($worker->verification_code)) {
                $worker->verification_code = static::generateVerificationCode();
            }
            if (empty($worker->verification_hash)) {
                $worker->verification_hash = static::generateVerificationHash();
            }
        });
    }

    // Media Library

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_photo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('documents');

        $this->addMediaCollection('signature')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->performOnCollections('profile_photo');

        $this->addMediaConversion('medium')
            ->width(400)
            ->height(400)
            ->performOnCollections('profile_photo');
    }

    // Activity Log

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn (string $eventName) => "Worker record {$eventName}")
            ->useLogName('workers');
    }

    // Relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function lga(): BelongsTo
    {
        return $this->belongsTo(Lga::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Worker::class, 'supervisor_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(Worker::class, 'supervisor_id');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(WorkerDocument::class);
    }

    public function employmentHistories(): HasMany
    {
        return $this->hasMany(EmploymentHistory::class);
    }

    public function verificationLogs(): HasMany
    {
        return $this->hasMany(VerificationLog::class);
    }

    // Accessors

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => trim("{$this->surname} {$this->first_name}" . ($this->middle_name ? " {$this->middle_name}" : ''))
        );
    }

    protected function age(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : null
        );
    }

    protected function profilePhotoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->hasMedia('profile_photo')) {
                    return $this->getFirstMediaUrl('profile_photo', 'thumb');
                }
                return null;
            }
        );
    }

    // Static helper methods

    public static function generateStaffNumber(): string
    {
        $prefix = 'LGA';
        $year = now()->format('Y');

        do {
            $sequence = str_pad(static::withTrashed()->count() + 1, 5, '0', STR_PAD_LEFT);
            $number = "{$prefix}/{$year}/{$sequence}";
        } while (static::withTrashed()->where('staff_number', $number)->exists());

        return $number;
    }

    public static function generateVerificationCode(): string
    {
        do {
            $code = strtoupper(Str::random(10));
        } while (static::where('verification_code', $code)->exists());

        return $code;
    }

    public static function generateVerificationHash(): string
    {
        do {
            $hash = hash('sha256', Str::uuid() . now()->timestamp);
        } while (static::where('verification_hash', $hash)->exists());

        return $hash;
    }

    // Scopes

    public function scopeVerified($query)
    {
        return $query->where('verification_status', VerificationStatus::Approved);
    }

    public function scopePending($query)
    {
        return $query->where('status', WorkerStatus::Pending);
    }

    public function scopeActive($query)
    {
        return $query->where('status', WorkerStatus::Active);
    }

    public function scopeSuspended($query)
    {
        return $query->where('status', WorkerStatus::Suspended);
    }

    public function scopeByDepartment($query, int $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('surname', 'like', "%{$term}%")
                ->orWhere('first_name', 'like', "%{$term}%")
                ->orWhere('middle_name', 'like', "%{$term}%")
                ->orWhere('staff_number', 'like', "%{$term}%")
                ->orWhere('employee_number', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('verification_code', 'like', "%{$term}%");
        });
    }

    // Helper methods

    public function isActive(): bool
    {
        return $this->status === WorkerStatus::Active;
    }

    public function isVerified(): bool
    {
        return $this->verification_status === VerificationStatus::Approved;
    }

    public function isPending(): bool
    {
        return $this->status === WorkerStatus::Pending;
    }
}
