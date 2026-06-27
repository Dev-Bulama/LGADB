<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lga extends Model
{
    use SoftDeletes;

    protected $table = 'lgas';

    protected $fillable = [
        'state_id',
        'name',
        'code',
        'address',
        'phone',
        'email',
        'website',
        'logo',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function wards(): HasMany
    {
        return $this->hasMany(Ward::class);
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function offices(): HasMany
    {
        return $this->hasMany(Office::class);
    }

    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
