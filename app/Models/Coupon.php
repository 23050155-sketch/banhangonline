<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_total',
        'max_uses',
        'used_count',
        'starts_at',
        'ends_at',
        'status',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
        'status'    => 'boolean',
    ];

    public function isActiveNow(): bool
    {
        if ((int)$this->status !== 1) return false;

        $now = now();
        if ($this->starts_at && $now->lt($this->starts_at)) return false;
        if ($this->expires_at && $now->gt($this->expires_at)) return false;

        if (!is_null($this->usage_limit) && $this->used_count >= $this->usage_limit) return false;

        return true;
    }

    public function calcDiscount(int $subtotal): int
    {
        if ($subtotal < (int)$this->min_order_total) return 0;

        if ($this->type === 'fixed') {
            return min((int)$this->value, $subtotal);
        }

        // percent
        $discount = (int) floor($subtotal * ((int)$this->value / 100));
        if (!is_null($this->max_discount)) {
            $discount = min($discount, (int)$this->max_discount);
        }
        return min($discount, $subtotal);
    }
}
