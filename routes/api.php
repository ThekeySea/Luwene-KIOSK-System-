<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CashierOrderController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\CustomerOrderController;
use App\Http\Controllers\Api\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);
    });

    Route::get('/restaurant/context', [RestaurantController::class, 'context']);
    Route::get('/restaurant/table/{qr_token}', [RestaurantController::class, 'resolveTable']);

    Route::get('/categories', [CatalogController::class, 'categories']);
    Route::get('/products', [CatalogController::class, 'products']);
    Route::get('/products/{slug}', [CatalogController::class, 'productDetail']);
    Route::get('/sambals', [CatalogController::class, 'sambals']);
    Route::get('/spice-levels', [CatalogController::class, 'spiceLevels']);
    Route::get('/modifier-groups', [CatalogController::class, 'modifierGroups']);
    Route::get('/packages', [CatalogController::class, 'packages']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/orders', [CustomerOrderController::class, 'create']);
        Route::get('/orders/{id}', [CustomerOrderController::class, 'show']);
        Route::get('/orders/{id}/status', [CustomerOrderController::class, 'status']);

        Route::get('/cashier/orders', [CashierOrderController::class, 'index']);
        Route::get('/cashier/orders/{id}', [CashierOrderController::class, 'show']);
        Route::patch('/cashier/orders/{id}/status', [CashierOrderController::class, 'updateStatus']);
        Route::post('/cashier/orders/{id}/verify-payment', [CashierOrderController::class, 'verifyPayment']);
    });
});
