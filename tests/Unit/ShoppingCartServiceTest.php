<?php

use App\Models\User;
use App\Services\ShoppingCart\ShoppingCartService;

test('add product to shopping cart', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
});

test('add non existing product to shopping cart', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
});

test('add product which is already existing to shopping cart', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
});

test('remove product from shopping cart', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
});

test('remove none existing product from shopping cart', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
});

test('remove 1 (amount) from shopping cart', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
});

test('get total price without taxes', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
});

test('get total price with taxes', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
});

test('get total price with coupon', function () {
    $service = $this->app->make(ShoppingCartService::class);
    $this->actingAs(User::all()->first());
});
