<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminCrudFlowTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'ADMIN',
        ]);

        $this->actingAs($this->admin);
    }

    public function test_products_page_requires_admin(): void
    {
        $this->get('/admin/products')
            ->assertStatus(200);
    }

    public function test_categories_page_requires_admin(): void
    {
        $this->get('/admin/categories')
            ->assertStatus(200);
    }

    public function test_promos_page_requires_admin(): void
    {
        $this->get('/admin/promos')
            ->assertStatus(200);
    }

    public function test_admin_can_create_product(): void
    {
        $category = Category::create(['name' => 'Ayam', 'is_active' => true]);

        Livewire::test('Admin\Products')
            ->call('openCreate')
            ->set('name', 'Nasi Goreng Spesial')
            ->set('category_id', $category->id)
            ->set('base_price', '25000')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('products', [
            'name' => 'Nasi Goreng Spesial',
            'base_price' => 25000,
        ]);
    }

    public function test_admin_can_edit_product(): void
    {
        $category = Category::create(['name' => 'Ayam', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Nasi Goreng',
            'base_price' => 20000,
            'is_active' => true,
        ]);

        Livewire::test('Admin\Products')
            ->call('openEdit', $product->id)
            ->set('name', 'Nasi Goreng Updated')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Nasi Goreng Updated',
        ]);
    }

    public function test_admin_can_toggle_product_availability(): void
    {
        $category = Category::create(['name' => 'Ayam', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Nasi Goreng',
            'base_price' => 20000,
            'is_active' => true,
            'is_available' => true,
        ]);

        Livewire::test('Admin\Products')
            ->call('toggleAvailable', $product->id);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_available' => false,
        ]);

        Livewire::test('Admin\Products')
            ->call('toggleAvailable', $product->id);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_available' => true,
        ]);
    }

    public function test_admin_can_publish_product(): void
    {
        $category = Category::create(['name' => 'Ayam', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Nasi Goreng',
            'base_price' => 20000,
            'is_active' => true,
            'is_published' => false,
        ]);

        Livewire::test('Admin\Products')
            ->call('publish', $product->id);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_published' => true,
        ]);
    }

    public function test_admin_can_unpublish_product(): void
    {
        $category = Category::create(['name' => 'Ayam', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Nasi Goreng',
            'base_price' => 20000,
            'is_active' => true,
            'is_published' => true,
        ]);

        Livewire::test('Admin\Products')
            ->call('unpublish', $product->id);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_published' => false,
        ]);
    }

    public function test_admin_can_soft_delete_product(): void
    {
        $category = Category::create(['name' => 'Ayam', 'is_active' => true]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Nasi Goreng',
            'base_price' => 20000,
            'is_active' => true,
        ]);

        Livewire::test('Admin\Products')
            ->call('destroy', $product->id);

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    public function test_admin_can_create_category(): void
    {
        Livewire::test('Admin\Categories')
            ->call('openCreate')
            ->set('name', 'Seafood')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('categories', ['name' => 'Seafood']);
    }

    public function test_admin_can_edit_category(): void
    {
        $category = Category::create(['name' => 'Ayam']);

        Livewire::test('Admin\Categories')
            ->call('openEdit', $category->id)
            ->set('name', 'Ayam & Bebek')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Ayam & Bebek',
        ]);
    }

    public function test_admin_cannot_delete_category_with_products(): void
    {
        $category = Category::create(['name' => 'Ayam']);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Nasi Goreng',
            'base_price' => 20000,
            'is_active' => true,
        ]);

        Livewire::test('Admin\Categories')
            ->call('destroy', $category->id);

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_admin_can_delete_empty_category(): void
    {
        $category = Category::create(['name' => 'Empty']);

        Livewire::test('Admin\Categories')
            ->call('destroy', $category->id);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_admin_can_publish_category(): void
    {
        $category = Category::create(['name' => 'Ayam', 'is_published' => false]);

        Livewire::test('Admin\Categories')
            ->call('publish', $category->id);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'is_published' => true,
        ]);
    }

    public function test_admin_can_unpublish_category(): void
    {
        $category = Category::create(['name' => 'Ayam', 'is_published' => true]);

        Livewire::test('Admin\Categories')
            ->call('unpublish', $category->id);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'is_published' => false,
        ]);
    }

    public function test_admin_can_create_promo(): void
    {
        Livewire::test('Admin\Promos')
            ->call('openCreate')
            ->set('code', 'HEMAT10')
            ->set('name', 'Diskon 10K')
            ->set('type', 'FIXED')
            ->set('value', '10000')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('promos', [
            'code' => 'HEMAT10',
            'type' => 'FIXED',
            'value' => 10000,
        ]);
    }

    public function test_admin_can_edit_promo(): void
    {
        $promo = Promo::create([
            'code' => 'HEMAT10',
            'name' => 'Diskon 10K',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => true,
        ]);

        Livewire::test('Admin\Promos')
            ->call('openEdit', $promo->id)
            ->set('name', 'Diskon 15K')
            ->set('value', '15000')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('promos', [
            'id' => $promo->id,
            'value' => 15000,
        ]);
    }

    public function test_admin_can_toggle_promo_active(): void
    {
        $promo = Promo::create([
            'code' => 'TEST',
            'name' => 'Test',
            'type' => 'FIXED',
            'value' => 5000,
            'min_order_amount' => 0,
            'is_active' => true,
        ]);

        Livewire::test('Admin\Promos')
            ->call('toggleActive', $promo->id);

        $this->assertDatabaseHas('promos', [
            'id' => $promo->id,
            'is_active' => false,
        ]);
    }

    public function test_admin_can_delete_promo(): void
    {
        $promo = Promo::create([
            'code' => 'TEST',
            'name' => 'Test',
            'type' => 'FIXED',
            'value' => 5000,
            'min_order_amount' => 0,
            'is_active' => true,
        ]);

        Livewire::test('Admin\Promos')
            ->call('destroy', $promo->id);

        $this->assertDatabaseMissing('promos', ['id' => $promo->id]);
    }

    public function test_duplicate_promo_code_rejected(): void
    {
        Promo::create([
            'code' => 'HEMAT10',
            'name' => 'First',
            'type' => 'FIXED',
            'value' => 10000,
            'min_order_amount' => 0,
            'is_active' => true,
        ]);

        Livewire::test('Admin\Promos')
            ->call('openCreate')
            ->set('code', 'HEMAT10')
            ->set('name', 'Duplicate')
            ->set('type', 'FIXED')
            ->set('value', '10000')
            ->call('save')
            ->assertHasErrors(['code']);
    }
}
