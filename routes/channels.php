<?php

use App\Models\Admin;
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

Broadcast::channel('App.Models.Admin.{id}', function (Admin $user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('deliveries.{order_id}', function (User $user, $order_id) {
    $order = Order::findOrFail($order_id);
    return (int) $order->user_id === (int) $user->id;
});

