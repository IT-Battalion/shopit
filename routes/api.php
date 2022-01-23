<?php

use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\HighlightedProductController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\OrderController;
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

Route::get('/user', function (Request $request) {
    return $request->user();
});

// Shopping Cart routes
Route::get('/user/shopping-cart', [ShoppingCartController::class, 'all']);
Route::post('/user/shopping-cart/add', [ShoppingCartController::class, 'add']);
Route::post('/user/shopping-cart/remove', [ShoppingCartController::class, 'remove']);

// Highlighted Products
Route::get('/highlighted', [HighlightedProductController::class, 'all']);

// Product routes
Route::apiResource('product', ProductController::class);

// Admin/Invoice routes
Route::get('/admin/invoices', [InvoiceController::class, 'all']);

// Admin/User routes
Route::get('/admin/users', [UserController::class, 'all']);

// Admin/Coupon routes
Route::get('/admin/coupons', [CouponController::class, 'all']);

// Admin/Orders routes
Route::get('/admin/orders', [OrderController::class, 'all']);
