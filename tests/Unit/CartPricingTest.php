<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Promo;
use App\Models\Setting;
use App\Services\CartPricing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartPricingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Setting::set('tax_rate', '11');
    }

    private function setCart(array $items): void
    {
        session(['cart' => $items]);
    }

    private function makeItem(float $subtotal): array
    {
        return [
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Nasi Goreng',
            'subtotal' => $subtotal,
        ];
    }

    public function test_empty_cart_returns_zero(): void
    {
        session(['cart' => []]);

        $this->assertEquals(0, CartPricing::subtotal());
        $this->assertEquals(0, CartPricing::discount());
        $this->assertEquals(0, CartPricing::total());
    }

    public function test_subtotal_calculation(): void
    {
        $this->setCart([
            $this->makeItem(35000),
            $this->makeItem(15000),
        ]);

        $this->assertEquals(50000, CartPricing::subtotal());
    }

    public function test_single_item_subtotal(): void
    {
        $this->setCart([
            $this->makeItem(25000),
        ]);

        $this->assertEquals(25000, CartPricing::subtotal());
    }

    public function test_tax_rate_from_settings(): void
    {
        Setting::set('tax_rate', '10');
        $this->assertEquals(0.10, CartPricing::taxRate());

        Setting::set('tax_rate', '11');
        $this->assertEquals(0.11, CartPricing::taxRate());
    }

    public function test_tax_without_discount(): void
    {
        $this->setCart([$this->makeItem(100000)]);

        $expectedTax = 100000 * 0.11;
        $this->assertEquals($expectedTax, CartPricing::tax());
    }

    public function test_total_without_promo(): void
    {
        $this->setCart([$this->makeItem(100000)]);

        $subtotal = 100000;
        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        $this->assertEquals($total, CartPricing::total());
        $this->assertEquals(0, CartPricing::discount());
    }

    public function test_no_promo_returns_null(): void
    {
        $this->setCart([$this->makeItem(50000)]);

        $this->assertNull(CartPricing::promo());
    }

    public function test_promo_code_returns_code_from_session(): void
    {
        session(['promo_code' => 'HEMAT10']);
        $this->assertEquals('HEMAT10', CartPricing::promoCode());

        session(['promo_code' => null]);
        $this->assertNull(CartPricing::promoCode());
    }

    public function test_fixed_promo_discount(): void
    {
        $promo = Promo::create([
            'code' => 'POTONGAN',
            'name' => 'Potongan',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => true,
        ]);

        $this->setCart([$this->makeItem(50000)]);
        session(['promo_code' => 'POTONGAN']);

        $this->assertEquals($promo->id, CartPricing::promo()->id);
        $this->assertEquals(10000, CartPricing::discount());
    }

    public function test_percent_promo_discount(): void
    {
        Promo::create([
            'code' => 'HEMAT10',
            'name' => 'Diskon 10%',
            'type' => 'PERCENT',
            'value' => 10,
            'min_order_amount' => 0,
            'is_active' => true,
        ]);

        $this->setCart([$this->makeItem(100000)]);
        session(['promo_code' => 'HEMAT10']);

        $this->assertEquals(10000, CartPricing::discount());
    }

    public function test_max_discount_caps_percent(): void
    {
        Promo::create([
            'code' => 'HEMAT10',
            'name' => 'Diskon 10% (maks 5000)',
            'type' => 'PERCENT',
            'value' => 10,
            'min_order_amount' => 0,
            'max_discount_amount' => 5000,
            'is_active' => true,
        ]);

        $this->setCart([$this->makeItem(100000)]);
        session(['promo_code' => 'HEMAT10']);

        $this->assertEquals(5000, CartPricing::discount());
    }

    public function test_discount_cannot_exceed_subtotal(): void
    {
        Promo::create([
            'code' => 'BESAR',
            'name' => 'Diskon Besar',
            'type' => 'FIXED',
            'value' => 200000,
            'min_order_amount' => 0,
            'is_active' => true,
        ]);

        $this->setCart([$this->makeItem(50000)]);
        session(['promo_code' => 'BESAR']);

        $this->assertEquals(50000, CartPricing::discount());
    }

    public function test_promo_not_applied_when_subtotal_below_minimum(): void
    {
        Promo::create([
            'code' => 'MIN50K',
            'name' => 'Min 50K',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 50000,
            'is_active' => true,
        ]);

        $this->setCart([$this->makeItem(30000)]);
        session(['promo_code' => 'MIN50K']);

        $this->assertNull(CartPricing::promo());
        $this->assertEquals(0, CartPricing::discount());
    }

    public function test_promo_applied_when_subtotal_meets_minimum(): void
    {
        Promo::create([
            'code' => 'MIN50K',
            'name' => 'Min 50K',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 50000,
            'is_active' => true,
        ]);

        $this->setCart([$this->makeItem(50000)]);
        session(['promo_code' => 'MIN50K']);

        $this->assertNotNull(CartPricing::promo());
        $this->assertEquals(10000, CartPricing::discount());
    }

    public function test_inactive_promo_not_applied(): void
    {
        Promo::create([
            'code' => 'INACTIVE',
            'name' => 'Nonaktif',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => false,
        ]);

        $this->setCart([$this->makeItem(50000)]);
        session(['promo_code' => 'INACTIVE']);

        $this->assertNull(CartPricing::promo());
        $this->assertEquals(0, CartPricing::discount());
    }

    public function test_expired_promo_not_applied(): void
    {
        Promo::create([
            'code' => 'EXPIRED',
            'name' => 'Kadaluarsa',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => true,
            'ends_at' => now()->subDay(),
        ]);

        $this->setCart([$this->makeItem(50000)]);
        session(['promo_code' => 'EXPIRED']);

        $this->assertNull(CartPricing::promo());
    }

    public function test_usage_limit_exceeded(): void
    {
        Promo::create([
            'code' => 'LIMITED',
            'name' => 'Terbatas',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => true,
            'usage_limit' => 5,
            'used_count' => 5,
        ]);

        $this->setCart([$this->makeItem(50000)]);
        session(['promo_code' => 'LIMITED']);

        $this->assertNull(CartPricing::promo());
    }

    public function test_total_with_discount(): void
    {
        Promo::create([
            'code' => 'HEMAT',
            'name' => 'Hemat',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => true,
        ]);

        $this->setCart([$this->makeItem(100000)]);
        session(['promo_code' => 'HEMAT']);

        $subtotal = 100000;
        $discount = 10000;
        $tax = ($subtotal - $discount) * 0.11;
        $total = $subtotal - $discount + $tax;

        $this->assertEquals($total, CartPricing::total());
    }

    public function test_items_returns_cart(): void
    {
        $items = [$this->makeItem(25000), $this->makeItem(35000)];
        $this->setCart($items);

        $this->assertEquals($items, CartPricing::items());
    }
}
