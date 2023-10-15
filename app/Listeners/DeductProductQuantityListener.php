<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;

class DeductProductQuantityListener
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
        $order = $event->order;
        foreach ($order->products as $product){
            $product->decrement('quantity', $product->pivot->quantity);
        }
    }
}
