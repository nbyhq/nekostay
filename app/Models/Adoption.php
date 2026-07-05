<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adoption extends Model
{
    /** @use HasFactory<\Database\Factories\AdoptionFactory> */
    use HasFactory;

    protected $fillable = [
        'cat_id',
        'adopter_name',
        'adopter_phone',
        'adopter_address',
        'status',
        'notes',
    ];

    public function cat(): BelongsTo
    {
        return $this->belongsTo(Cat::class);
    }
}
