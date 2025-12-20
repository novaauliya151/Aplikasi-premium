<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'order_number',
        'subtotal',
        'shipping',
        'total',
        'status',
        'payment_status',
        'payment_proof',
        'payment_method',
        'notes',
        'verified_at',
        'access_sent_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
