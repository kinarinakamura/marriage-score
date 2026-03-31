<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosisResult extends Model
{
    protected $fillable = [
        'gender',
        'answers',
        'is_extended',
        'hensachi',
        'is_high_score',
    ];

    protected $casts = [
        'answers'       => 'array',
        'is_extended'   => 'boolean',
        'is_high_score' => 'boolean',
    ];
}
