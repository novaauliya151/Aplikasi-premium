<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'variant_id',
        'name',
        'type',
        'value',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'value' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    // Relasi ke ProductVariant
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    // Cek apakah promo masih berlaku
    public function getIsValidAttribute()
    {
        if (!$this->is_active) {
            return false;
        }

        $today = now()->format('Y-m-d');
        return $this->start_date->format('Y-m-d') <= $today 
            && $this->end_date->format('Y-m-d') >= $today;
    }

    // Format label diskon
    public function getDiscountLabelAttribute()
    {
        if ($this->type === 'nominal') {
            return 'Rp ' . number_format($this->value, 0, ',', '.');
        } else {
            return $this->value . '%';
        }
    }
}
