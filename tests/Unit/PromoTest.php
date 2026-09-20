<?php

namespace Tests\Unit;

use App\Models\Promo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromoTest extends TestCase
{
    use RefreshDatabase;

    public function test_fixed_discount(): void
    {
        $promo = Promo::create([
            'code' => 'FIX10K',
            'name' => 'Potongan 10K',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => true,
        ]);

        $this->assertEquals(10000, $promo->calculateDiscount(50000));
    }

    public function test_fixed_discount_not_exceeding_subtotal(): void
    {
        $promo = Promo::create([
            'code' => 'BIG',
            'name' => 'Diskon Besar',
            'type' => 'FIXED',
            'value' => 200000,
            'min_order_amount' => 0,
            'is_active' => true,
        ]);

        $this->assertEquals(50000, $promo->calculateDiscount(50000));
    }

    public function test_percent_discount(): void
    {
        $promo = Promo::create([
            'code' => 'PCT10',
            'name' => '10%',
            'type' => 'PERCENT',
            'value' => 10,
            'min_order_amount' => 0,
            'is_active' => true,
        ]);

        $this->assertEquals(10000, $promo->calculateDiscount(100000));
    }

    public function test_percent_discount_rounding(): void
    {
        $promo = Promo::create([
            'code' => 'PCT7',
            'name' => '7%',
            'type' => 'PERCENT',
            'value' => 7,
            'min_order_amount' => 0,
            'is_active' => true,
        ]);

        $result = $promo->calculateDiscount(10000);
        $this->assertEqualsWithDelta(700, $result, 0.01);
    }

    public function test_max_discount_caps_percent(): void
    {
        $promo = Promo::create([
            'code' => 'CAPPED',
            'name' => 'Diskon Capped',
            'type' => 'PERCENT',
            'value' => 20,
            'min_order_amount' => 0,
            'max_discount_amount' => 15000,
            'is_active' => true,
        ]);

        // 20% dari 100000 = 20000, tapi cap 15000
        $this->assertEquals(15000, $promo->calculateDiscount(100000));
    }

    public function test_max_discount_does_not_affect_lower_amounts(): void
    {
        $promo = Promo::create([
            'code' => 'CAPPED',
            'name' => 'Diskon Capped',
            'type' => 'PERCENT',
            'value' => 20,
            'min_order_amount' => 0,
            'max_discount_amount' => 15000,
            'is_active' => true,
        ]);

        // 20% dari 50000 = 10000, masih di bawah cap
        $this->assertEquals(10000, $promo->calculateDiscount(50000));
    }

    public function test_discount_not_applied_when_subtotal_below_minimum(): void
    {
        $promo = Promo::create([
            'code' => 'MIN50K',
            'name' => 'Min 50K',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 50000,
            'is_active' => true,
        ]);

        $this->assertEquals(0, $promo->calculateDiscount(30000));
    }

    public function test_discount_applied_when_subtotal_meets_minimum(): void
    {
        $promo = Promo::create([
            'code' => 'MIN50K',
            'name' => 'Min 50K',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 50000,
            'is_active' => true,
        ]);

        $this->assertEquals(10000, $promo->calculateDiscount(50000));
    }

    public function test_inactive_promo_returns_zero(): void
    {
        $promo = Promo::create([
            'code' => 'OFF',
            'name' => 'Nonaktif',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => false,
        ]);

        $this->assertEquals(0, $promo->calculateDiscount(50000));
    }

    public function test_expired_promo_returns_zero(): void
    {
        $promo = Promo::create([
            'code' => 'EXPIRED',
            'name' => 'Kadaluarsa',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => true,
            'ends_at' => now()->subDay(),
        ]);

        $this->assertEquals(0, $promo->calculateDiscount(50000));
    }

    public function test_not_yet_started_promo_returns_zero(): void
    {
        $promo = Promo::create([
            'code' => 'FUTURE',
            'name' => 'Masa Depan',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => true,
            'starts_at' => now()->addDays(7),
        ]);

        $this->assertEquals(0, $promo->calculateDiscount(50000));
    }

    public function test_usage_limit_exceeded(): void
    {
        $promo = Promo::create([
            'code' => 'LIMITED',
            'name' => 'Terbatas',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => true,
            'usage_limit' => 5,
            'used_count' => 5,
        ]);

        $this->assertEquals(0, $promo->calculateDiscount(50000));
    }

    public function test_usage_limit_not_yet_reached(): void
    {
        $promo = Promo::create([
            'code' => 'LIMITED',
            'name' => 'Terbatas',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => true,
            'usage_limit' => 5,
            'used_count' => 4,
        ]);

        $this->assertEquals(10000, $promo->calculateDiscount(50000));
    }

    public function test_no_usage_limit(): void
    {
        $promo = Promo::create([
            'code' => 'UNLIMITED',
            'name' => 'Tanpa Batas',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => true,
            'usage_limit' => null,
        ]);

        $this->assertEquals(10000, $promo->calculateDiscount(50000));
    }

    public function test_is_active_with_valid_dates(): void
    {
        $promo = Promo::create([
            'code' => 'NOW',
            'name' => 'Aktif',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => true,
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDay(),
        ]);

        $this->assertTrue($promo->isActive());
    }

    public function test_label_fixed(): void
    {
        $promo = Promo::create([
            'code' => 'FIX',
            'name' => 'Test',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => true,
        ]);

        $this->assertEquals('Potongan Rp 10.000', $promo->label());
    }

    public function test_label_percent(): void
    {
        $promo = Promo::create([
            'code' => 'PCT',
            'name' => 'Test',
            'type' => 'PERCENT',
            'value' => 10,
            'min_order_amount' => 0,
            'is_active' => true,
        ]);

        $this->assertEquals('Diskon 10%', $promo->label());
    }

    public function test_label_with_max_discount(): void
    {
        $promo = Promo::create([
            'code' => 'CAPPED',
            'name' => 'Test',
            'type' => 'PERCENT',
            'value' => 15,
            'min_order_amount' => 0,
            'max_discount_amount' => 20000,
            'is_active' => true,
        ]);

        $this->assertStringContainsString('maks Rp 20.000', $promo->label());
    }
}
