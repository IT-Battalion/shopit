<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Models\OrderProductImage;
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

// Auth
Route::view('/login', 'vue');

// Main Content
Route::view('/', 'vue')->name('home');
Route::view('/produkte/{name}', 'vue')->name('products.show');

// User profile
Route::prefix('user')->name('user.')->group(function () {
    Route::view('/', 'vue')->name('profile');
    Route::view('/bestellverlauf', 'vue')->name('orders.index');
});

// Admin Page
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/rechnungen', 'vue')->name('invoices.index');
    Route::view('/bestellungen', 'vue')->name('orders.index');
    Route::view('/coupons', 'vue')->name('coupons.index');
    Route::view('/kategorien', 'vue')->name('categories.index');

    // Usermanagement
    Route::prefix('users')->name('users.')->group(function () {
        Route::view('/', 'vue')->name('users.index');
        Route::view('/{id}', 'vue')->name('users.show');
    });

    // Products
    Route::prefix('produkte')->name('products.')->group(function () {
        Route::view('/bearbeiten', 'vue')->name('edit');
        Route::view('/hinzufuegen', 'vue')->name('store');
        Route::view('/hinzufuegen/preisUndTitel', 'vue')->name('store.meta');
    });

    // User
    Route::prefix('user')->name('users.')->group(function () {
        Route::view('/', 'vue')->name('list');
        Route::view('/{id}', 'vue')->name('show');
    });
});

// Order
Route::prefix('order')->name('order.')->group(function () {
    Route::view('/', 'vue')->name('index');
});

Route::permanentRedirect('/home', url('/'));

// custom login/logout Routes because we have the auth middleware installed on the whole 'web' route domain
// therefore we needed the withoutMiddle() function to disable the auth middleware for the login routes
Broadcast::routes();

Route::namespace('Auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth');
    Route::view('/login', 'vue')->name('login');
});

Route::middleware('auth')->group(function () {
    /*Route::get('/icon/{icon}', function (Icon $icon) {
        $path = Storage::path($icon->path);

        if (!File::exists($path)) {
            abort(404);
        }

        return response()->file($path);
    })
        ->middleware('auth')
        ->name('icon');*/

    Route::get('/product-image/{image}', function (ProductImage $image) {
        $path = Storage::path($image->path);

        if (!File::exists($path)) {
            abort(404);
        }

        return response()->file($path);
    })->name('product-image');

    Route::get('/order-product-image/{image}', function (OrderProductImage $image) {
        $path = Storage::path($image->path);

        if (!File::exists($path)) {
            abort(404);
        }

        return response()->file($path);
    });
});
