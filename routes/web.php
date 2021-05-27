<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

Route::get('/', function () {
    return view('home');
});

Route::get('/home', 'HomeController@index')->name('home');

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
    Route::post('logout', 'LoginController@logout')->name('logout');
});

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::prefix('/shopping-cart')->group(function () {
    Route::get('/', 'ShoppingCartController@index')->name('shopping-cart');
    Route::post('/add/{product_id}', 'ShoppingCartController@add')->name('shopping-cart.add');
    Route::post('/remove/{product_id}', 'ShoppingCartController@remove')->name('shopping-cart.remove');
});

Route::resource('products', 'ProductsController');
Route::resource('products.images', 'ProductImagesController')->except([
    'index', 'create', 'edit',
]);

Route::get('/user/{id}', function ($id) {
    return QrCode::generate(User::find($id)->name);
})->middleware('admin');
