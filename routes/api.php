<?php

use App\Http\Controllers\Api\BanController;
use App\Http\Controllers\Api\HighlightedProductController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ShoppingCartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Highlighted Products
Route::get('/highlighted', [HighlightedProductController::class, 'all']);

// Product routes
Route::apiResource('product', ProductController::class);

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', function (Request $request) {
        return $request->user();
    });

    // Shopping Cart routes
    Route::get('/shopping-cart', [ShoppingCartController::class, 'all']);
    Route::post('/shopping-cart', [ShoppingCartController::class, 'add']);
    Route::post('/shopping-cart/remove', [ShoppingCartController::class, 'remove']);
    Route::post('/shopping-cart/coupon', [ShoppingCartController::class, 'applyCoupon']);
    Route::post('/shopping-cart/coupon/reset', [ShoppingCartController::class, 'resetCoupon']);

    // Order routes
    Route::get('/orders', [OrderController::class, 'userAll']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{order}', [OrderController::class, 'userShow']);
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Invoice routes
    Route::get('/invoices', [InvoiceController::class, 'all']);

    // User routes
    Route::apiResource('/users', 'UserController')->only(['index', 'show']);

    // Coupon routes
    Route::apiResource('/coupons', 'CouponController')->only(['index', 'store']);

    // Orders routes
    Route::get('/orders', [OrderController::class, 'all']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::get('/orders/user/{user}', [OrderController::class, 'userAdminAll']);

    // Category Routes
    Route::apiResource('category', 'CategoryController')->only('update', 'store', 'destroy');

    Route::get('/ban/user/{user}/info', [BanController::class, 'info']);
    Route::post('/ban/user/{user}/ban', [BanController::class, 'ban']);
    Route::post('/ban/user/{user}/unban', [BanController::class, 'unban']);
});
