<?php

use Illuminate\Support\Facades\Broadcast;
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
    Route::view('/login', 'home')->withoutMiddleware('auth')->name('login');
    Route::view('/logout', 'home')->name('logout');
});

Route::get('/icon/{id}', function (int $id) {
    $icon = \App\Models\Icon::whereId($id)->first();
    return response()->file($icon->path);
})->name('icon');

Route::view('/{route}', 'home')
    ->where('route', '.*')
    ->name('home')
    ->withoutMiddleware('auth');
