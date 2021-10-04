<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() : void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Instance of Illuminate\Routing\UrlGenerator
        $urlGenerator = $this->app['url'];

        // Instance of Illuminate\Http\Request
        $request = $this->app['request'];

        // Grabbing the root url
        $root = $request->root();

        // Add the suffix
        //$rootSuffix = '/index.php';
        $rootSuffix = '';
        if (!str_ends_with($root, $rootSuffix)) {
            $root .= $rootSuffix;
        }

        // Finally set the root url on the UrlGenerator
        $urlGenerator->forceRootUrl($root);
    }
}
