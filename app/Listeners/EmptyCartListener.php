<?php

namespace App\Listeners;

use App\Http\Facades\Cart;
use App\Http\Interfaces\CartRepositoryInterface;


class EmptyCartListener
{
    /**
     * Create the event listener.
     */
    protected CartRepositoryInterface $cart;

    public function __construct()
    {
       //
    }

    /**
     * Handle the event.
     */
    public function handle(): void
    {
        Cart::empty();
    }
}
