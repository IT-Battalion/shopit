<?php

use App\Models\Admin;
use App\Models\OrderProductImage;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

/*Artisan::command('clean:icons', function () {
    $dbIcons = Icon::all()->map(fn (Icon $icon) => $icon->path);
    $unnecessaryFiles = collect(Storage::files('icons', true))->diff($dbIcons);
    $fileCount = $unnecessaryFiles->count();

    if ($fileCount === 0) {
        $this->info('No unnecessary icon image files were found');
        return;
    }

    $this->info("$fileCount unnecessary icon image files were found. deleting...");
    if (!Storage::delete($unnecessaryFiles->all())) {
        $this->error('Failed to delete the images');
    }
})->describe('Cleanup icon image files that aren\'t in the database');*/

Artisan::command('clean:productImages', function () {
    $dbIcons = ProductImage::all()->map(fn (ProductImage $image) => $image->path);
    $unnecessaryFiles = collect(Storage::files('product/images', true))->diff($dbIcons);
    $fileCount = $unnecessaryFiles->count();

    if ($fileCount === 0) {
        $this->info('No unnecessary product image files were found');
        return;
    }

    $this->info("$fileCount unnecessary product image files were found. deleting...");
    if (!Storage::delete($unnecessaryFiles->all())) {
        $this->error('Failed to delete the images');
    }
})->describe('Cleanup product image files that aren\'t in the database');


Artisan::command('clean:orderProductImages', function () {
    $dbIcons = OrderProductImage::all()->map(fn (OrderProductImage $image) => $image->path);
    $unnecessaryFiles = collect(Storage::files('order/product/images', true))->diff($dbIcons);
    $fileCount = $unnecessaryFiles->count();

    if ($fileCount === 0) {
        $this->info('No unnecessary order product image files were found');
        return;
    }

    $this->info("$fileCount unnecessary order product image files were found. deleting...");
    if (!Storage::delete($unnecessaryFiles->all())) {
        $this->error('Failed to delete the images');
    }
})->describe('Cleanup order product image files that aren\'t in the database');

Artisan::command('clean', function () {
    $commands = array_filter(array_keys(Artisan::all()), fn ($command) => Str::startsWith($command, 'clean:'));

    foreach ($commands as $command) {
        $this->call($command, []);
    }
});

/*Artisan::command('icon:add {id} {--interactionless}', function (string $id, bool $interactionless, IconServiceInterface $iconService) {
    $icon = $iconService->findById($id);

    $this->info('Found an icon:');
    $this->line("Name: $icon->name");
    $this->line("Author: $icon->artist");

    $continue = $interactionless || $this->confirm('Möchten Sie dieses icon herunterladen? ', true);
    if ($continue) {
        $icon = $iconService->add($icon);
        if ($icon->exists()) {
            $this->info('Successfully created icon');
        } else {
            $this->error('Failed to create icon');
        }
    }
});*/

Artisan::command('user:get {--admin} {--normal}', function ($admin, $normal) {
    if ($admin) {
        $this->info(Admin::inRandomOrder()->first()->username);
    } else if ($normal) {
        $this->info(User::notAdmin()->inRandomOrder()->first()->username);
    } else {
        $this->info(User::inRandomOrder()->first()->username);
    }
});

Artisan::command('admin:get', function () {
    $this->info(Admin::inRandomOrder()->first()->username);
});
