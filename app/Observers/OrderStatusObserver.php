<?php

namespace App\Observers;

use App\Events\OrderCreatedEvent;
use App\Events\OrderHandedOverEvent;
use App\Events\OrderPaidEvent;
use App\Events\OrderProductsOrderedEvent;
use App\Events\OrderProductsReceivedEvent;
use App\Models\Order;
use App\Types\OrderStatus;

class OrderStatusObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        $this->fireOrderChangeEvent($order);
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        $this->fireOrderChangeEvent($order);
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }

    private function fireOrderChangeEvent(Order $order): void
    {
        $eventClass = match ($order->status) {
            OrderStatus::CREATED => OrderCreatedEvent::class,
            OrderStatus::PAID => OrderPaidEvent::class,
            OrderStatus::ORDERED => OrderProductsOrderedEvent::class,
            OrderStatus::RECEIVED => OrderProductsReceivedEvent::class,
            OrderStatus::HANDED_OVER => OrderHandedOverEvent::class,
        };

        info("Sending event " . $eventClass);
        broadcast(new $eventClass($order))->toOthers();
    }
}
