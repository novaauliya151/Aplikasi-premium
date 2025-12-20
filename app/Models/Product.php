<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'features',
        'packages',
        'image'
    ];

    // Relasi ke ProductVariant
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Get varian yang aktif
    public function activeVariants()
    {
        return $this->hasMany(ProductVariant::class)->where('is_active', true);
    }

    /**
     * Get full URL for the product image (or null if not set).
     * Uses Storage::url so it works with different disks (public, s3, etc.).
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        // Return the URL regardless of existence check
        // This allows the image to display even if Storage::exists has issues
        return Storage::disk('public')->url($this->image);
    }
}
