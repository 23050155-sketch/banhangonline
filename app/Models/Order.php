<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name','customer_phone','customer_email','customer_address',
        'subtotal','shipping_fee','discount_amount','coupon_code',
        'total','payment_method','status','note'
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'shipping_fee' => 'integer',
        'discount_amount' => 'integer',
        'total' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
