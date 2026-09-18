<?php

use App\Livewire\Customer\CartPage;
use App\Livewire\Customer\CheckoutPage;
use App\Livewire\Customer\EntryPage;
use App\Livewire\Customer\MenuPage;
use App\Livewire\Customer\OrderTrackingPage;
use App\Livewire\Customer\ProductDetailPage;
use App\Livewire\Kasir\Dashboard;
use App\Livewire\Kasir\MenuAvailability;
use App\Livewire\Kasir\TableManagement;
use Illuminate\Support\Facades\Route;

Route::get('/', EntryPage::class)->name('customer.entry');
Route::get('/menu', MenuPage::class)->name('customer.menu');
Route::get('/menu/{slug}', ProductDetailPage::class)->name('customer.product');
Route::get('/cart', CartPage::class)->name('customer.cart');
Route::get('/checkout', CheckoutPage::class)->name('customer.checkout');
Route::get('/order/{id}', OrderTrackingPage::class)->name('customer.order-tracking');

Route::get('/kasir', Dashboard::class)->name('cashier.dashboard');
Route::get('/kasir/menu', MenuAvailability::class)->name('cashier.menu');
Route::get('/kasir/tables', TableManagement::class)->name('cashier.tables');
