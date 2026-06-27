<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'department_id',
        'name',
        'code',
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

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function head(): BelongsTo
    {
        return $this->belongsTo(Worker::class, 'head_id');
    }

    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
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
