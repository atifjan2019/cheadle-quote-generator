<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScopeSection extends Model
{
    public $timestamps = false;

    protected $fillable = ['quote_id', 'section_name', 'section_description', 'is_heading', 'sort_order'];

    protected $casts = [
        'is_heading' => 'boolean',
    ];
}
