<?php

namespace App\Listeners;

use App\Events\OrderStatusChangedEvent;
use App\Mail\OrderCreatedMail;
use App\Models\Order;
use App\Types\OrderStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class OrderStatusListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  App\Events\OrderStatusChangedEvent  $event
     * @return void
     */
    public function handle(OrderStatusChangedEvent $event)
    {
        info("listener fired!");
        info($event->order);
        switch ($event->order->customer) {
            case OrderStatus::CREATED:
                Mail::to(auth()->user()->email)->queue(new OrderCreatedMail());
                break;
            case OrderStatus::PAID:
                throw new \Exception('To be implemented');
                break;
            case OrderStatus::ORDERED:
                throw new \Exception('To be implemented');
                break;
            case OrderStatus::RECEIVED:
                throw new \Exception('To be implemented');
                break;
            case OrderStatus::HANDED_OVER:
                throw new \Exception('To be implemented');
        }
    }
}
