<?php

namespace App\Listeners;

use App\Events\OrderStatusChangedEvent;
use App\Mail\OrderCreatedMail;
use App\Mail\PaymentConfirmationMail;
use App\Mail\PickUpConfirmationMail;
use App\Mail\ProductArrivalMail;
use App\Mail\ProductDeliveryMail;
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
        info($event->order->customer);
        switch ($event->order->status) {
            case OrderStatus::CREATED:
                Mail::to($event->order->customer->email)->queue(new OrderCreatedMail($event->order));
                break;
            case OrderStatus::PAID:
                Mail::to($event->order->customer->email)->queue(new PaymentConfirmationMail($event->order));
                break;
            case OrderStatus::ORDERED:
                Mail::to($event->order->customer->email)->queue(new ProductDeliveryMail($event->order));
                break;
            case OrderStatus::RECEIVED:
                Mail::to($event->order->customer->email)->queue(new ProductArrivalMail($event->order));
                break;
            case OrderStatus::HANDED_OVER:
                Mail::to($event->order->customer->email)->queue(new PickUpConfirmationMail($event->order));
        }
    }
}
