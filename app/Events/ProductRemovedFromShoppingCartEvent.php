<?php

namespace App\Events;

use App\Models\Product;
use App\Models\User;
use App\Types\Money;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProductRemovedFromShoppingCartEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        public Product          $product,
        public array|Collection $selected_attributes,
        public Money $subtotal,
        public Money $discount,
        public Money $tax,
        public Money $total,
        private int|User|null   $user = null)
    {
        if (is_null($user)) {
            $this->user = Auth::user()?->id;
        } elseif($this->user instanceof User) {
            $this->user = $this->user->id;
        }
    }

    public function broadcastWhen() {
        return $this->user !== null;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel(`app.user.${$this->user->id}.shopping-cart`);
    }
}
