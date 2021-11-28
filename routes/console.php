<?php

use App\Models\Icon;
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

    if ($this->confirm("$fileCount unnecessary icon image files were found. Do you wish to continue?")) {
        if (!Storage::delete($unnecessaryFiles->all())) {
            $this->error('Failed to delete the files');
        }
    }
})->describe('Cleanup icon image files that aren\'t in the database');
