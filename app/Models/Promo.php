<?php

namespace App\Models;

use App\Traits\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasUuids;

    protected $fillable = [
        'code', 'name', 'type', 'value',
        'min_order_amount', 'max_discount_amount',
        'is_active', 'starts_at', 'ends_at',
        'usage_limit', 'used_count',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'max_discount_amount' => 'decimal:2',
            'is_active' => 'boolean',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function isActive(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        $now = now();

        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }

        if ($this->ends_at && $now->gt($this->ends_at)) {
            return false;
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if (! $this->isActive() || $subtotal < (float) $this->min_order_amount) {
            return 0;
        }

        $discount = $this->type === 'PERCENT'
            ? $subtotal * ((float) $this->value / 100)
            : (float) $this->value;

        if ($this->max_discount_amount !== null) {
            $discount = min($discount, (float) $this->max_discount_amount);
        }

        return min($discount, $subtotal);
    }

    public function label(): string
    {
        $base = $this->type === 'PERCENT'
            ? 'Diskon '.rtrim(rtrim(number_format((float) $this->value, 2), '0'), '.').'%'
            : 'Potongan Rp '.number_format((float) $this->value, 0, ',', '.');

        if ($this->max_discount_amount !== null) {
            $base .= ' (maks Rp '.number_format((float) $this->max_discount_amount, 0, ',', '.').')';
        }

        return $base;
    }
}
