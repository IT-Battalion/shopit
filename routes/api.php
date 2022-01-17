<?php

use App\Http\Controllers\Api\HighlightedProductController;
use App\Http\Controllers\Api\ShoppingCartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/user/shopping-cart', [ShoppingCartController::class, 'all']);
Route::get('/user/shopping-cart/add', [ShoppingCartController::class, 'add']);

// Highlighted Products
Route::get('/highlighted', [HighlightedProductController::class, 'all']);

// Product routes
Route::apiResource('product', ProductController::class);
