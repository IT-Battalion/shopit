<?php

use App\Http\Controllers\Api\BanController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\HighlightedProductController;
use App\Http\Controllers\Api\ImageUploadController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\LegalDocumentsController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ShoppingCartController;
use App\Http\Controllers\Api\UserController;
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
Route::apiResource('product', ProductController::class)->only(['index', 'show']);

// Legal Documents (AGB, Impressum, ..) routes
Route::get('/impressum/get', [LegalDocumentsController::class, 'impressum']);
Route::get('/agb/get', [LegalDocumentsController::class, 'agb']);

// User routes
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', function (Request $request) {
        return response()->json($request->user());
    })->name('data');

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
    Route::get('/invoice', [InvoiceController::class, 'all']);

    // User routes
    Route::apiResource('/users', UserController::class)->only(['index', 'show']);

    // Coupon routes
    Route::apiResource('/coupons', CouponController::class)->only(['index', 'store']);

    // Orders routes
    Route::apiResource('orders', OrderController::class)->except(['store', 'delete']);
    Route::get('/orders/user/{user}', [OrderController::class, 'userAdminAll']);

    // Category Routes
    Route::apiResource('category', CategoryController::class)->only(['update', 'store', 'destroy', 'index']);

    // Ban Routes
    Route::get('/ban/user/{user}/info', [BanController::class, 'info']);
    Route::post('/ban/user/{user}/ban', [BanController::class, 'ban']);
    Route::post('/ban/user/{user}/unban', [BanController::class, 'unban']);

    // Product Routes
    Route::get('product/{product}', [ProductController::class, 'showAdmin']);
    Route::apiResource('product', ProductController::class)->only(['store', 'update', 'destroy']);
    Route::get('productImage', [ImageUploadController::class, 'load']);
    Route::post('productImage', [ImageUploadController::class, 'process']);
    Route::delete('productImage', [ImageUploadController::class, 'revert']);
    Route::get('productImages/{product}', [ProductController::class, 'getFilePondIds']);

    // Legal Documents (AGB, Impressum, ..) Routes
    Route::post('/impressum/set', [LegalDocumentsController::class, 'setimpressum']);
    Route::post('/agb/set', [LegalDocumentsController::class, 'setagb']);
});
