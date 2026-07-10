<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cat extends Model
{
    /** @use HasFactory<\Database\Factories\CatFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'breed',
        'gender',
        'age_estimate',
        'color',
        'status',
        'rescue_location',
        'photo',
        'description',
    ];

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function adoptions(): HasMany
    {
        return $this->hasMany(Adoption::class);
    }
    
}
