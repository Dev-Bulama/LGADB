<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Department extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'lga_id',
        'name',
        'code',
        'slug',
        'description',
        'head_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Department $department) {
            if (empty($department->slug)) {
                $department->slug = Str::slug($department->name);
            }
        });

        static::updating(function (Department $department) {
            if ($department->isDirty('name') && empty($department->slug)) {
                $department->slug = Str::slug($department->name);
            }
        });
    }

    public function lga(): BelongsTo
    {
        return $this->belongsTo(Lga::class);
    }

    public function head(): BelongsTo
    {
        return $this->belongsTo(Worker::class, 'head_id');
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
    }

    public function offices(): HasMany
    {
        return $this->hasMany(Office::class);
    }

    public function employmentHistories(): HasMany
    {
        return $this->hasMany(EmploymentHistory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
