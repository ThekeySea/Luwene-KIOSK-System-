<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders(): void
    {
        $this->get('/login')
            ->assertRedirect(route('delivery.login'));
    }

    public function test_login_with_valid_credentials(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'ADMIN',
        ]);

        Livewire::test('Auth\Login')
            ->set('email', 'admin@test.com')
            ->set('password', 'password')
            ->call('login')
            ->assertHasNoErrors()
            ->assertRedirect('/admin/dashboard');
    }

    public function test_login_with_invalid_credentials(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'ADMIN',
        ]);

        Livewire::test('Auth\Login')
            ->set('email', 'admin@test.com')
            ->set('password', 'wrong')
            ->call('login')
            ->assertHasErrors(['email']);
    }

    public function test_register_page_renders(): void
    {
        $this->get('/register')
            ->assertStatus(200);
    }

    public function test_register_creates_customer_user(): void
    {
        Livewire::test('Auth\Register')
            ->set('name', 'Test User')
            ->set('email', 'test@test.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('register')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
            'role' => 'CUSTOMER',
        ]);
    }

    public function test_logout_clears_session(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'ADMIN',
        ]);

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect();

        $this->assertGuest();
    }

    public function test_unauthenticated_user_redirected_to_login(): void
    {
        $this->get('/admin/dashboard')
            ->assertRedirect('/login');
    }

    public function test_customer_cannot_access_admin(): void
    {
        $user = User::create([
            'name' => 'Customer',
            'email' => 'cust@test.com',
            'password' => bcrypt('password'),
            'role' => 'CUSTOMER',
        ]);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertStatus(403);
    }

    public function test_cashier_cannot_access_admin(): void
    {
        $user = User::create([
            'name' => 'Kasir',
            'email' => 'kasir@test.com',
            'password' => bcrypt('password'),
            'role' => 'CASHIER',
        ]);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertStatus(403);
    }
}
