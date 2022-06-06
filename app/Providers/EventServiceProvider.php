<?php

namespace App\Providers;

use App\Events\OrderStatusChangedEvent;
use App\Listeners\OrderStatusListener;
use App\Models\Order;
use App\Models\Product;
use App\Observers\OrderStatusObserver;
use App\Observers\ProductObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        OrderStatusChangedEvent::class => [
            OrderStatusListener::class,
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $observers = [
        Product::class => [
            ProductObserver::class,
        ],
        Order::class => [
            OrderStatusObserver::class,
        ],
    ];

}
