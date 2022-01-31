<?php

use App\Exceptions\ActionNotAllowedForAdministratorException;
use App\Models\Admin;
use App\Models\User;
use App\Services\Users\UserService;

beforeEach(function () {
    Admin::factory()->create();
});

test('user can be banned', function () {
    $admin = Admin::inRandomOrder()->first()->get()->first();
    $this->actingAs($admin);
    $service = $this->app->make(UserService::class);

    $user = User::factory()->enabled()->create();

    $service->ban($user, 'Test');

    expect($user->enabled)->toBeFalse();
    expect($user->disabled_at)->not()->toBeNull();
    expect($user->disabled_by->id)->toBe($admin->id);
});

test('user can be unbanned', function () {
    $admin = Admin::inRandomOrder()->first()->get()->first();
    $this->actingAs($admin);
    /** @var UserService $service */
    $service = $this->app->make(UserService::class);

    $user = User::factory()->disabled()->create();

    $service->unban($user);

    expect($user->enabled)->toBeTrue();
    expect($user->disabled_at)->toBeNull();
    expect($user->disabled_by)->toBeNull();
});

test('admin can not be banned', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(UserService::class);
    $admin = Admin::whereEnabled(true)->get()->random();

    $service->ban($admin, 'Test');
})->throws(ActionNotAllowedForAdministratorException::class);

test('admin can not be unbanned', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(UserService::class);
    $admin = Admin::factory()->disabled()->create();

    $service->unban($admin);
})->throws(ActionNotAllowedForAdministratorException::class);

test('is user banned', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(UserService::class);
    $user = User::factory()->disabled()->create();

    expect($user->enabled)->toBeFalse();
});

test('is user not banned', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(UserService::class);
    $user = User::factory()->enabled()->create();

    expect($user->enabled)->toBeTrue();
});
