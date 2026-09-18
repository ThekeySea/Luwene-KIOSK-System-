<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', App\Livewire\Customer\EntryPage::class)->name('home');

Route::get('/login', App\Livewire\Auth\Login::class)->name('login');
Route::get('/register', App\Livewire\Auth\Register::class)->name('register');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

Route::get('/dashboard', function () {
    if (!Auth::check()) return redirect()->route('login');
    return match(Auth::user()->role) {
        'ADMIN' => redirect()->route('admin.dashboard'),
        'CASHIER' => redirect()->route('cashier.dashboard'),
        'CUSTOMER' => redirect()->route('customer.dashboard'),
        default => redirect()->route('login'),
    };
})->name('dashboard');

// Customer Kiosk - public (no auth required)
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('/menu', App\Livewire\Customer\Menu::class)->name('menu');
    Route::get('/menu/kategori/{categorySlug}', App\Livewire\Customer\MenuCategory::class)->name('menu.category');
    Route::get('/menu/{slug}', App\Livewire\Customer\ProductDetail::class)->name('product');
    Route::get('/cart', App\Livewire\Customer\Cart::class)->name('cart');
    Route::get('/info', App\Livewire\Customer\CustomerInfo::class)->name('info');
    Route::get('/checkout', App\Livewire\Customer\Checkout::class)->name('checkout');
    Route::get('/order/{orderId}/success', App\Livewire\Customer\OrderSuccess::class)->name('order-success');
    Route::get('/order/{orderId}/receipt', function (string $orderId) {
        $order = \App\Models\Order::with(['items.modifiers', 'payment', 'branch', 'table'])->findOrFail($orderId);

        return response(view('receipts.order-plain', ['order' => $order])->render(), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="struk-'.$order->order_number.'.txt"',
        ]);
    })->name('order-receipt');
    Route::get('/promo', App\Livewire\Customer\Promo::class)->name('promo');
    Route::get('/faq', App\Livewire\Customer\Faq::class)->name('faq');
    Route::get('/order/{orderId}', App\Livewire\Customer\OrderTracking::class)->name('order-tracking');
});

// Customer - auth required
Route::middleware(['auth', 'role:CUSTOMER'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', App\Livewire\Customer\Dashboard::class)->name('dashboard');
    Route::get('/orders', App\Livewire\Customer\Orders::class)->name('orders');
});

// Cashier
Route::middleware(['auth', 'role:CASHIER,ADMIN', 'restaurant.context'])->prefix('kasir')->name('cashier.')->group(function () {
    Route::get('/dashboard', App\Livewire\Staff\CashierDashboard::class)->name('dashboard');
    Route::get('/pos', App\Livewire\Staff\Pos::class)->name('pos');
});

// Admin
Route::middleware(['auth', 'role:ADMIN', 'restaurant.context'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', App\Livewire\Staff\AdminDashboard::class)->name('dashboard');
});
