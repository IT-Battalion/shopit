<?php

use App\Exceptions\ActionNotAllowedForAdministratorExeption;
use App\Models\User;
use App\Services\Users\UserService;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

test('user can be banned', function () {
    $service = app()->make(UserService::class);
    $user = User::whereEnabled(true)->where('isAdmin', false)->get()->random();
    User::factory()->create();
    $service->ban($user);
    assertFalse(User::whereId($user->id)->first()->enabled);
});

test('user can be unbanned', function () {
    $service = app()->make(UserService::class);
    $user = User::where('isAdmin', '=', false)->get()->random();
    User::factory()->create();
    $user->enabled = false;
    $user->save();
    $service->unban($user);
    assertTrue(User::whereId($user->id)->first()->enabled);
});

test('admin can not be banned', function () {
    $service = app()->make(UserService::class);
    $admin = User::whereEnabled(true)->where('isAdmin', true)->get()->random();

    $service->ban($admin);
})->throws(ActionNotAllowedForAdministratorExeption::class);

test('admin can not be unbanned', function () {
    $service = app()->make(UserService::class);
    $admin = User::whereEnabled(true)->where('isAdmin', true)->get()->random();

    $admin->enabled = false;
    $admin->save();
    $service->unban($admin);
})->throws(ActionNotAllowedForAdministratorExeption::class);

test('is user banned', function ()  {
    $service = app()->make(UserService::class);
    $user = User::where('isAdmin', '=', false)->get()->random();
    User::factory()->create();
    $user->enabled = false;
    $user->save();
    assertTrue($service->isBanned($user));
});

test('is user not banned', function ()  {
    $service = app()->make(UserService::class);
    $user = User::whereEnabled(true)->get()->random();

    assertFalse($service->isBanned($user));
});
