<?php

namespace App\Providers;

use App\Services\Icons\IconServiceInterface;
use App\Services\Icons\TheNounProjectService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use App\Services\Icons\Api\ApiClient;

class IconServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @var array|string[] All the container singletons that should be registered.
     */

    public array $singletons = [
        IconServiceInterface::class => TheNounProjectService::class,
    ];

    public function register()
    {
        $this->app->singleton(ApiClient::class, function () {
            return new ApiClient(
                config('shop.icon.api_key'),
                config('shop.icon.api_secret'));
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            IconServiceInterface::class,
            ApiClient::class];
    }
}
