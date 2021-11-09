<?php

use App\Exceptions\CouponCodeDiscounOutOfBoundsException;
use App\Exceptions\CouponCodeNotFoundException;
use App\Models\Admin;
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
    $service = $this->app->make(CouponService::class);
    $code = CouponCode::whereEnabled(true)->get()->random();
    $service->markAsUsed($code->code);
    expect($service->isUsed($code->code))->toBeTrue();
});

test('get coupon by code', function () {
    $service = $this->app->make(CouponService::class);
    $code = CouponCode::all()->random();
    $code2 = $service->get($code->code);
    expect(isset($code2))->toBeTrue();
});

test('create coupon code', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(CouponService::class);
    $code = $service->create(20, now(), 'test');
    expect(isset($code))->toBeTrue();
});

test('create coupon code with to high discount', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(CouponService::class);
    $service->create(120, now(), 'test');
})->throws(CouponCodeDiscounOutOfBoundsException::class);

test('create coupon code with to low discount', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(CouponService::class);
    $service->create(-120, now(), 'test');
})->throws(CouponCodeDiscounOutOfBoundsException::class);

test('delete coupon code', function () {
    $service = $this->app->make(CouponService::class);
    $service->delete('test');
    $service->get('test');
})->throws(CouponCodeNotFoundException::class);
