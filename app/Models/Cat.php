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

    /**
     * Resolve the correct public URL for the cat photo, regardless of source:
     * - full external URL (http/https)
     * - seeded local image (images/seed-cats/...)
     * - uploaded file (stored in storage/app/public/...)
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->photo) {
            return null;
        }

        if (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://')) {
            return $this->photo;
        }

        if (str_starts_with($this->photo, 'images/')) {
            return asset($this->photo);
        }

        return asset('storage/'.$this->photo);
    }
}
