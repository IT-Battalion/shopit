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

Route::view('/', 'home')->name('home')->withoutMiddleware('auth');

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