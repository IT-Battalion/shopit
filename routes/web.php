<?php

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

Route::get('/', 'HomeController@index')->name('home');

Route::permanentRedirect('/home', url('/'));

/*Auth::routes([
    'register' => false,
    'verify' => false,
    'reset' => false,
]);*/


// custom login/logout Routes because we have the auth middleware installed on the whole 'web' route domain
// therefore we needed the withoutMiddle() function to disable the auth middleware for the login routes
Route::namespace('Auth')->group(function () {
    Route::get('/login', 'LoginController@showLoginForm')->withoutMiddleware('auth')->name('login');
    Route::post('/login', 'LoginController@login')->withoutMiddleware('auth');
    Route::post('/logout', 'LoginController@logout')->name('logout');
});

Route::prefix('/shopping-cart')->group(function () {
    Route::get('/', 'ShoppingCartController@index')->name('shopping-cart');
    Route::post('/add/{product_id}', 'ShoppingCartController@add')->name('shopping-cart.add');
    Route::delete('/remove/{product_id}', 'ShoppingCartController@remove')->name('shopping-cart.remove');
});

Route::resource('products', 'ProductsController');
Route::resource('products.images', 'ProductImagesController')->except([
    'index', 'create', 'edit',
]);
Route::resource('profile', 'ProfileController');

Route::prefix('admin')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/{id}', 'UserController@show')->middleware('admin');
        Route::put('/ban/{id}', 'UserController@ban')->middleware('admin');
        Route::put('/unban/{id}', 'UserController@unban')->middleware('admin');
    });

    Route::prefix('invoice')->group(function () {
        Route::get('/{invoice_id}', 'InvoiceController@show')->middleware('admin');
        Route::get('/download/{invoice_id}', 'InvoiceController@download')->middleware('admin');
    });

    Route::prefix('order')->group(function () {
        Route::get('/{order_id}', 'OrderController@show')->middleware('admin');
    });
});
