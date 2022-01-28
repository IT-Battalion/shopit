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

class ProductAddedToShoppingCartEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $product;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        Product                 $product,
        public int              $count,
        public array|Collection $selected_attributes,
        public Money            $price,
        public Money            $subtotal,
        public Money            $discount,
        public Money            $tax,
        public Money            $total,
        private int|User|null   $user = null)
    {
        if (is_null($user)) {
            $this->user = Auth::user();
        } else if (is_int($this->user)) {
            $this->user = User::find($this->user);
        }

        $this->product = $product->jsonSerialize();

        if (is_array($this->selected_attributes)) {
            $this->selected_attributes = collect($this->selected_attributes);
        }

        $this->selected_attributes = $this->selected_attributes->map(function ($attribute) {
            return $attribute->jsonSerialize();
        });
    }

    public function broadcastWhen()
    {
        return $this->user !== null;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("app.user.{$this->user->id}.shopping-cart");
    }
}
