<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalRecord extends Model
{
    protected $fillable = [
    'cat_id',
    'visit_date',
    'next_visit_date',
    'next_visit_note',
    'doctor',
    'diagnosis',
    'treatment',
    'notes',
    'weight',
    'temperature',
    'status',
];

    public function cat(): BelongsTo
    {
        return $this->belongsTo(Cat::class);
    }
}
