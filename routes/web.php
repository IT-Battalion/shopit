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

Route::view('/', 'home')->name('home');
Route::view('/login', 'home');
Route::view('/product/{name}', 'home')->where('name', '[^\/]*');
Route::view('/admin/', 'home');
Route::view('/admin/rechnungen', 'home');
Route::view('/admin/bestellverlauf', 'home');
Route::view('/admin/bestellungen', 'home');
Route::view('/admin/userverwaltung', 'home');
Route::view('/admin/userverwaltung/users/{id}', 'home');
Route::view('/admin/coupons', 'home');
Route::view('/admin/kategorien', 'home');
Route::view('/admin/produkte/bearbeiten', 'home');
Route::view('/admin/produkte/hinzufuegen', 'home');
Route::view('/admin/produkte/hinzufuegen/preisUndTitel', 'home');
Route::view('/order/', 'home');

Route::permanentRedirect('/home', url('/'));

// custom login/logout Routes because we have the auth middleware installed on the whole 'web' route domain
// therefore we needed the withoutMiddle() function to disable the auth middleware for the login routes
Broadcast::routes();

Route::namespace('Auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth');
    Route::view('/login', 'home')->name('login');
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
