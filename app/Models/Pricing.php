<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'quote_id',
        'base_cost_label',
        'base_cost',
        'additional_cost_label',
        'additional_cost',
        'total_cost',
        'total_cost_label',
        'price_breakdown',
        'notes',
        'exclusions',
    ];

    protected $casts = [
        'base_cost' => 'decimal:2',
        'additional_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];
}
