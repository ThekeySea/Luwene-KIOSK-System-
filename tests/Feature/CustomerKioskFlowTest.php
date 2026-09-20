<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use App\Models\RestaurantTable;
use App\Models\DiningSession;
use App\Models\Promo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CustomerKioskFlowTest extends TestCase
{
    use RefreshDatabase;

    protected Branch $branch;

    protected function setUp(): void
    {
        parent::setUp();

        $this->branch = Branch::create(['name' => 'LUWENE Main', 'status' => 'ACTIVE']);
    }

    public function test_entry_page_renders(): void
    {
        $this->get('/')
            ->assertStatus(200);
    }

    public function test_menu_page_renders(): void
    {
        $this->get('/customer/menu')
            ->assertStatus(200);
    }

    public function test_menu_category_page_renders(): void
    {
        $category = Category::create(['name' => 'Ayam', 'is_active' => true, 'is_published' => true]);

        $this->get("/customer/menu/kategori/{$category->slug}")
            ->assertStatus(200);
    }

    public function test_product_detail_page_renders(): void
    {
        $category = Category::create(['name' => 'Ayam', 'is_active' => true, 'is_published' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Nasi Goreng',
            'base_price' => 25000,
            'is_active' => true,
            'is_available' => true,
            'is_published' => true,
        ]);

        $this->get("/customer/menu/{$product->slug}")
            ->assertStatus(200);
    }

    public function test_unpublished_product_returns_404(): void
    {
        $category = Category::create(['name' => 'Ayam', 'is_active' => true, 'is_published' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Hidden Item',
            'base_price' => 25000,
            'is_active' => true,
            'is_available' => true,
            'is_published' => false,
        ]);

        $this->get("/customer/menu/{$product->slug}")
            ->assertStatus(404);
    }

    public function test_promo_page_renders(): void
    {
        $this->get('/customer/promo')
            ->assertStatus(200);
    }

    public function test_faq_page_renders(): void
    {
        $this->get('/customer/faq')
            ->assertStatus(200);
    }

    public function test_info_page_renders(): void
    {
        $this->get('/customer/info')
            ->assertStatus(200);
    }

    public function test_takeaway_sets_order_mode_in_session(): void
    {
        Livewire::test(\App\Livewire\Customer\EntryPage::class)
            ->call('selectTakeAway')
            ->assertRedirect('/customer/menu');

        $this->assertEquals('TAKE_AWAY', session('order_mode'));
    }

    public function test_dine_in_sets_order_mode_in_session(): void
    {
        $table = RestaurantTable::create([
            'branch_id' => $this->branch->id,
            'table_number' => 1,
            'capacity' => 4,
            'status' => 'AVAILABLE',
        ]);

        Livewire::test(\App\Livewire\Customer\EntryPage::class)
            ->call('selectTable', $table->id)
            ->assertRedirect('/customer/menu');

        $this->assertEquals('DINE_IN', session('order_mode'));
        $this->assertNotNull(session('table_id'));
        $this->assertDatabaseHas('dining_sessions', [
            'branch_id' => $this->branch->id,
            'table_id' => $table->id,
        ]);
    }
}
