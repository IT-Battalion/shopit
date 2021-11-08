<?php

use App\Models\CouponCode;
use App\Services\Coupons\CouponService;

test('is coupon used', function () {
    $service = $this->app->make(CouponService::class);
    $code = CouponCode::whereEnabled(true)->get()->random();
    expect($service->isUsed($code->code))->toBeFalse();
});

test('is coupon unused', function () {
    $service = $this->app->make(CouponService::class);
    $code = CouponCode::whereEnabled(true)->get()->random();
    expect($service->isUsed($code->code))->toBeFalse();
});

test('change used status of coupon', function () {
    $service = app()->make(CouponService::class);
    $code = CouponCode::whereEnabled(false)->get()->random();
    $service->markAsUsed($code->code);
    expect($service->isUsed($code->code))->toBeTrue();
});

test('get coupon by code', function () {
    $service = app()->make(CouponService::class);
    $code = CouponCode::all()->random();
    $code2 = $service->get($code->code);
    expect(isset($code2))->toBeTrue();
});

test('create coupon code', function () {
    $service = app()->make(CouponService::class);
    $service->create('test', 20, now());
    $code = CouponCode::whereCode('test')->get()->first();
    expect(isset($code))->toBeTrue();
});
