<?php

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
    Route::get('/users/{id}/orders', [OrderController::class, 'show']);

    // Category Routes
    Route::apiResource('category', 'CategoryController');
});

Route::get('/user/orders', [OrderController::class, 'userAll']);
