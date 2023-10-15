<?php

namespace App\Http\Facades;

use App\Http\Repositories\CartRepository;
use Illuminate\Support\Facades\Facade;

class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CartRepository::class;
    }
}
