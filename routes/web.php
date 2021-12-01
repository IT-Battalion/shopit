<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Models\Icon;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::permanentRedirect('/home', url('/'));

/*Auth::routes([
    'register' => false,
    'verify' => false,
    'reset' => false,
]);*/


// custom login/logout Routes because we have the auth middleware installed on the whole 'web' route domain
// therefore we needed the withoutMiddle() function to disable the auth middleware for the login routes
Broadcast::routes();

Route::namespace('Auth')->group(function () {
    Route::post('login', [LoginController::class, 'login'])->withoutMiddleware('auth');
    Route::post('logout', [LogoutController::class, 'logout'])->middleware('auth');
    Route::view('/login', 'home')->name('login');
});

Route::get('/icon/{id}', function (int $id) {
    $icon = Icon::whereId($id);

    if (!$icon->exists()) {
        abort(404);
    }

    $icon = $icon->first();
    $path = storage_path("app/$icon->path");

    if (!File::exists($path)) {
        abort(404);
    }

    return response()->file($path);
})
    ->middleware('auth')
    ->name('icon');

Route::get('/product-image/{id}', function (int $id) {
    $image = ProductImage::whereId($id)->first();

    if (!$image->exists()) {
        abort(404);
    }

    $icon = $image->first();
    $path = storage_path("app/$image->path");

    if (!File::exists($path)) {
        abort(404);
    }

    return response()->file($path);
})
    ->middleware('auth')
    ->name('product-image');

Route::view('/{route}', 'home')
    ->where('route', '.*')
    ->name('home');
