<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevisionNote extends Model
{
    public $timestamps = false;

    protected $fillable = ['quote_id', 'note_text', 'is_bold', 'sort_order'];

    protected $casts = [
        'is_bold' => 'boolean',
    ];
}
