<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationLog extends Model
{
    protected $fillable = [
        'worker_id', 'searched_by', 'search_query', 'search_type',
        'ip_address', 'user_agent', 'result_found',
    ];

    protected $casts = ['result_found' => 'boolean'];

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
