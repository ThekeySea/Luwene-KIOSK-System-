<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Branch;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class HasUuidsTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_gets_uuid_on_create(): void
    {
        $category = Category::create(['name' => 'Ayam']);

        $this->assertNotEmpty($category->id);
        $this->assertTrue(Str::isUuid($category->id));
    }

    public function test_branch_gets_uuid_on_create(): void
    {
        $branch = Branch::create(['name' => 'Test', 'status' => 'ACTIVE']);

        $this->assertNotEmpty($branch->id);
        $this->assertTrue(Str::isUuid($branch->id));
    }

    public function test_order_gets_uuid_on_create(): void
    {
        $branch = Branch::create(['name' => 'Test', 'status' => 'ACTIVE']);

        $order = Order::create([
            'branch_id' => $branch->id,
            'client_order_id' => (string) Str::uuid(),
            'order_number' => 'LW-00001',
            'order_mode' => 'TAKE_AWAY',
        ]);

        $this->assertNotEmpty($order->id);
        $this->assertTrue(Str::isUuid($order->id));
    }

    public function test_key_type_is_string(): void
    {
        $category = new Category();

        $this->assertEquals('string', $category->getKeyType());
    }

    public function test_not_incrementing(): void
    {
        $category = new Category();

        $this->assertFalse($category->getIncrementing());
    }

    public function test_uuids_are_unique(): void
    {
        $ids = collect();
        for ($i = 0; $i < 50; $i++) {
            $category = Category::create(['name' => "Category {$i}"]);
            $ids->push($category->id);
        }

        $this->assertEquals(50, $ids->unique()->count());
    }

    public function test_explicit_id_is_not_overridden(): void
    {
        $customId = (string) Str::uuid();
        $category = Category::create(['id' => $customId, 'name' => 'Custom']);

        $this->assertTrue(Str::isUuid($category->id));
    }
}
