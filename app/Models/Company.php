<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'nib',
        'npwp',
        'logo_path',
        'banner_path',
        'status',
    ];

    public function universities(): BelongsToMany
    {
        return $this->belongsToMany(University::class, 'company_university')
            ->withPivot(['status', 'mou_file', 'mou_expires_at'])
            ->withTimestamps();
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'company_users')
            ->withPivot(['role'])
            ->withTimestamps();
    }
}
