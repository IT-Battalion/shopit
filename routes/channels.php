<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('app.user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('app.user.{id}.shopping-cart', function (User $user, $id) {
    return $user->id === (int) $id;
});

Broadcast::channel('app.order.{order}', function (User $user, Order $order) {
    return $user->id === $order->customer_id || $user->is_admin;
});
