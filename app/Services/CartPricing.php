<?php

namespace App\Services;

use App\Models\Promo;

class CartPricing
{
    public static function items(): array
    {
        return session('cart', []);
    }

    public static function subtotal(): float
    {
        return (float) collect(static::items())->sum('subtotal');
    }

    public static function promo(): ?Promo
    {
        $code = session('promo_code');

        if (! $code) {
            return null;
        }

        $promo = Promo::where('code', $code)->first();

        if (! $promo || ! $promo->isActive()) {
            return null;
        }

        if (static::subtotal() < (float) $promo->min_order_amount) {
            return null;
        }

        return $promo;
    }

    public static function promoCode(): ?string
    {
        return session('promo_code');
    }

    public static function discount(): float
    {
        $promo = static::promo();

        return $promo ? $promo->calculateDiscount(static::subtotal()) : 0;
    }

    public static function tax(): float
    {
        return (static::subtotal() - static::discount()) * 0.11;
    }

    public static function total(): float
    {
        return static::subtotal() - static::discount() + static::tax();
    }
}
