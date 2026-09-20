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
    Route::get('/packages', App\Livewire\Customer\Packages::class)->name('packages');
    Route::get('/packages/{code}', App\Livewire\Customer\PackageDetail::class)->name('package');
    Route::get('/cart', App\Livewire\Customer\Cart::class)->name('cart');
    Route::get('/info', App\Livewire\Customer\CustomerInfo::class)->name('info');
    Route::get('/checkout', App\Livewire\Customer\Checkout::class)->name('checkout');
    Route::get('/order/{orderId}/success', App\Livewire\Customer\OrderSuccess::class)->name('order-success');
    Route::get('/order/{orderId}/receipt', function (string $orderId) {
        $order = \App\Models\Order::with(['items.modifiers', 'payment', 'branch', 'table'])->findOrFail($orderId);
        $barcode = \Milon\Barcode\Facades\DNS1DFacade::getBarcodePNG($order->order_number, 'C128', 2, 60);

        $trackingUrl = route('customer.order-tracking', $order->id);
        $qrCode = \Milon\Barcode\Facades\DNS2DFacade::getBarcodePNG($trackingUrl, 'QR', 4, 4);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('receipts.order-pdf', [
            'order' => $order,
            'barcode' => $barcode,
            'qrCode' => $qrCode,
        ]);
        $pdf->setPaper([0, 0, 226.77, 650], 'portrait');

        return $pdf->download('struk-'.$order->order_number.'.pdf');
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
    Route::get('/scan', App\Livewire\Staff\ScanOrder::class)->name('scan');
    Route::get('/scan/{code}', function (string $code) {
        return redirect()->route('cashier.scan', ['code' => $code]);
    })->where('code', '[A-Za-z0-9-]+')->name('scan-code');
});

// Admin
Route::middleware(['auth', 'role:ADMIN', 'restaurant.context'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', App\Livewire\Staff\AdminDashboard::class)->name('dashboard');
    Route::get('/products', App\Livewire\Admin\Products::class)->name('products');
    Route::get('/packages', App\Livewire\Admin\Packages::class)->name('packages');
    Route::get('/categories', App\Livewire\Admin\Categories::class)->name('categories');
    Route::get('/sambals', App\Livewire\Admin\Sambals::class)->name('sambals');
    Route::get('/addons', App\Livewire\Admin\ModifierGroups::class)->name('modifier-groups');
    Route::get('/promos', App\Livewire\Admin\Promos::class)->name('promos');
    Route::get('/branches', App\Livewire\Admin\Branches::class)->name('branches');
    Route::get('/staff', App\Livewire\Admin\Staff::class)->name('staff');
    Route::get('/transactions', App\Livewire\Admin\Transactions::class)->name('transactions');
    Route::get('/reports', App\Livewire\Admin\Reports::class)->name('reports');
    Route::get('/settings', App\Livewire\Admin\Settings::class)->name('settings');
});

// Delivery - placeholder (akan dibangun di fase berikutnya)
Route::prefix('delivery')->name('delivery.')->group(function () {
    Route::get('/home', function () {
        return redirect()->route('home')->with('error', 'Fitur Delivery segera hadir!');
    })->name('home');
});
