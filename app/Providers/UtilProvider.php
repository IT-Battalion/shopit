<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UtilProvider extends ServiceProvider
{
    public array $helpers = [
        'Util/translation.php',
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->helpers as $helper) {
            require_once app_path($helper);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
