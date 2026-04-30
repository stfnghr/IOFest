<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobCustomQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'question',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
