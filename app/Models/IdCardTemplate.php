<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdCardTemplate extends Model
{
    protected $fillable = [
        'name',
        'front_html',
        'back_html',
        'css',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (IdCardTemplate $template) {
            // Ensure only one template is default at a time
            if ($template->is_default) {
                static::where('id', '!=', $template->id ?? 0)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }
        });
    }

    public static function getDefault(): ?static
    {
        return static::where('is_default', true)
            ->where('is_active', true)
            ->first()
            ?? static::where('is_active', true)->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function setAsDefault(): void
    {
        static::where('is_default', true)->update(['is_default' => false]);
        $this->update(['is_default' => true]);
    }
}
