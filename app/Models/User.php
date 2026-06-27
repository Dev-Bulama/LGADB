<?php

namespace App\Models;

use App\Enums\RoleType;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'uuid',
        'employee_id',
        'staff_number',
        'role_type',
        'is_active',
        'last_login_at',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'is_active' => 'boolean',
            'role_type' => RoleType::class,
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->uuid)) {
                $user->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    // Relationships

    public function worker(): HasOne
    {
        return $this->hasOne(Worker::class);
    }

    public function createdWorkers(): HasMany
    {
        return $this->hasMany(Worker::class, 'verified_by');
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'author_id');
    }

    // Accessors

    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role_type === RoleType::SuperAdmin;
    }

    public function isHrOfficer(): bool
    {
        return $this->role_type === RoleType::HrOfficer;
    }

    public function isDepartmentManager(): bool
    {
        return $this->role_type === RoleType::DepartmentManager;
    }
}
