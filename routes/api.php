<?php

use App\Http\Controllers\Api\ProductController;
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

// Highlighted Products
Route::apiResource('/highlighted', HighlightedProductController::class);

// Product routes
Route::get('/product/', [ProductController::class, 'index']);
Route::get('/product/{name}', [ProductController::class, 'show']);
//Route::apiResource('/product', ProductController::class);
