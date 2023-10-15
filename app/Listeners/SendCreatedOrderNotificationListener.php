<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Models\Admin;
use App\Notifications\OrderCreatedNotification;
use function Symfony\Component\Translation\t;

class SendCreatedOrderNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreatedEvent $event): void
    {
        $order =$event->order;
        $admin = Admin::where('store_id', $order->store_id)->first();
        $admin->notify(new OrderCreatedNotification($order));

                    /* if multi admin exists, we can do..
        $admins = User::where('store_id', $order->store_id)->get();
        foreach ($admins as $admin) {
            $admin->notify(new OrderCreatedNotification($order));
        }
                                or
        Notification::send($users , new OrderCreatedNotification($order)); */
    }
}
