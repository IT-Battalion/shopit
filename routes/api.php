<?php

use App\Http\Controllers\API\ProductController;
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

Route::apiResource('/highlighted', HighlightedProductController::class);
Route::get('/product/', [ProductController::class, 'index']);
Route::get('/product/{name}', [ProductController::class, 'show']);
//Route::apiResource('/product', ProductController::class);
