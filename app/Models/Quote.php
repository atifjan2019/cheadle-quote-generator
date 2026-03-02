<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quote extends Model
{
    protected $fillable = [
        'date',
        'project_ref',
        'client_name',
        'client_address',
        'project_description',
        'architect',
        'structural_engineer',
        'prepared_by',
        'status',
        'project_photo',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function revisionNotes(): HasMany
    {
        return $this->hasMany(RevisionNote::class)->orderBy('sort_order');
    }

    public function scopeSections(): HasMany
    {
        return $this->hasMany(ScopeSection::class)->orderBy('sort_order');
    }

    public function pricing(): HasOne
    {
        return $this->hasOne(Pricing::class);
    }
}
