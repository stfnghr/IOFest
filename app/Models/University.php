<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sso_domain',
        'logo_path',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_university')
            ->withPivot(['status', 'mou_file', 'mou_expires_at'])
            ->withTimestamps();
    }
}
