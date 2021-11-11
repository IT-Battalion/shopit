<?php

use App\Exceptions\ActionNotAllowedForAdministratorExeption;
use App\Models\Admin;
use App\Models\User;
use App\Services\Users\UserService;

test('user can be banned', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(UserService::class);
    $user = User::whereEnabled(true)->where('isAdmin', false)->get()->random();
    User::factory()->create();
    $service->ban($user);
    expect(User::whereId($user->id)->first()->enabled)->toBeFalse();
});

test('user can be unbanned', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(UserService::class);
    $user = User::where('isAdmin', '=', false)->get()->random();
    User::factory()->create();
    $user->enabled = false;
    $user->save();
    $service->unban($user);
    expect(User::whereId($user->id)->first()->enabled)->toBeTrue();
});

test('admin can not be banned', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(UserService::class);
    $admin = Admin::whereEnabled(true)->get()->random();

    $service->ban($admin);
})->throws(ActionNotAllowedForAdministratorExeption::class);

test('admin can not be unbanned', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(UserService::class);
    $admin = Admin::all()->random();

    $admin->enabled = false;
    $admin->save();
    $service->unban($admin);
})->throws(ActionNotAllowedForAdministratorExeption::class);

test('is user banned', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(UserService::class);
    $user = User::all()->random();
    $user->enabled = false;
    $user->save();
    expect($service->isBanned($user))->toBeTrue();
});

test('is user not banned', function () {
    $this->actingAs(Admin::all()->random());
    $service = $this->app->make(UserService::class);
    $user = User::whereEnabled(true)->get()->random();

    expect($service->isBanned($user))->toBeFalse();
});

//TODO make test if disabled_by property is set correct throughout events. Events need to be listening on bans but idk how
