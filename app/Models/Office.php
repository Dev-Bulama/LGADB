<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'lga_id',
        'department_id',
        'name',
        'code',
        'address',
        'gps_lat',
        'gps_lng',
        'phone',
        'email',
        'head_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'gps_lat' => 'decimal:7',
            'gps_lng' => 'decimal:7',
        ];
    }

    public function lga(): BelongsTo
    {
        return $this->belongsTo(Lga::class);
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
