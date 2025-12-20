<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'price',
        'stock',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke Promo
    public function promos()
    {
        return $this->hasMany(Promo::class, 'variant_id');
    }

    // Get promo aktif yang sedang berlaku
    public function getActivePromoAttribute()
    {
        $today = now()->format('Y-m-d');
        
        return $this->promos()
            ->where('is_active', true)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();
    }

    // Hitung harga akhir setelah promo
    public function getFinalPriceAttribute()
    {
        $basePrice = $this->price;
        $promo = $this->active_promo;

        if (!$promo) {
            return $basePrice;
        }

        if ($promo->type === 'nominal') {
            return max(0, $basePrice - $promo->value);
        } else { // percent
            $discount = ($basePrice * $promo->value) / 100;
            return max(0, $basePrice - $discount);
        }
    }

    // Hitung jumlah diskon
    public function getDiscountAmountAttribute()
    {
        return $this->price - $this->final_price;
    }
}
