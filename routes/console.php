<?php

use App\Models\Icon;
use App\Models\OrderProductImage;
use App\Models\ProductImage;
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

Artisan::command('clean:icons', function () {
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
})->describe('Cleanup icon image files that aren\'t in the database');

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
