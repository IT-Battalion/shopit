<?php

use App\Http\Controllers\Api\DocumentController;
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

// TEST ROUTES! PLEASE REMOVE AFTER USE
Route::view('/bill', 'documents.bill');
Route::view('/voucher', 'documents.voucher');

// Auth
Route::view('/login', 'vue');

//Credits
Route::view('/credits', 'vue');
Route::view('/contributors', 'vue');
Route::view('/agb', 'vue');
Route::view('/impressum', 'vue');

// Main Content
Route::view('/', 'vue')->name('home');
Route::view('/products/{name}', 'vue')->name('products.show');

// User profile
Route::prefix('profile')->name('profil.')->group(function () {
    Route::view('/', 'vue')->name('profile');
    Route::view('/order-history', 'vue')->name('orders.index');

    // Order
    Route::prefix('orders/')->name('order.')->group(function () {
        Route::view('{order}/', 'vue')->name('show');
        Route::get('{order}/bill', [DocumentController::class, 'bill']);
        Route::get('{order}/voucher', [DocumentController::class, 'voucher']);
    });
});

// Admin Page
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'vue')->name('profile');
    Route::view('/invoices', 'vue')->name('invoices.index');
    Route::view('/coupons', 'vue')->name('coupons.index');
    Route::view('/categories', 'vue')->name('categories.index');

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::view('/', 'vue')->name('orders.index');
        Route::view('/{order}', 'vue')->name('orders.show');
        Route::get('/{order}/bill', [DocumentController::class, 'bill']);
        Route::get('/{order}/voucher', [DocumentController::class, 'voucher']);
    });

    // Usermanagement
    Route::prefix('users')->name('users.')->group(function () {
        Route::view('/', 'vue')->name('users.index');
        Route::view('/{id}', 'vue')->name('users.show');
    });

    // Products
    Route::prefix('products')->name('products.')->group(function () {
        Route::view('/edit', 'vue')->name('edit');
        Route::view('/add', 'vue')->name('store');
    });

    // User
    Route::prefix('user')->name('users.')->group(function () {
        Route::view('/', 'vue')->name('list');
        Route::view('/{id}', 'vue')->name('show');
    });
});

Route::view('/shopping-cart/', 'vue')->name('shopping-cart');

// Credits


Route::permanentRedirect('/home', url('/'));

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
