<?php

namespace App\Providers;

use App\Services\Categories\CategoryService;
use App\Services\Categories\CategoryServiceInterface;
use App\Services\Coupons\CouponService;
use App\Services\Coupons\CouponServiceInterface;
use App\Services\Products\ProductService;
use App\Services\Products\ProductServiceInterface;
use App\Services\Users\UserService;
use App\Services\Users\UserServiceInterface;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        UserServiceInterface::class => UserService::class,
        CouponServiceInterface::class => CouponService::class,
        CategoryServiceInterface::class => CategoryService::class,
        ProductServiceInterface::class => ProductService::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
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
        $rootSuffix = config('app.url_root_suffix', ''); // pull from configuration with none as default
        // needed on the projekte.tgm.ac.at server
        // because the configuration doesn't support
        // .htaccess files for the rewrite engine
        if (!str_ends_with($root, $rootSuffix)) {
            $root .= $rootSuffix;
        }

        // Finally set the root url on the UrlGenerator
        $urlGenerator->forceRootUrl($root);
    }
}
