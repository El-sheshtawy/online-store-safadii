<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function show(Order $order)
    {
        $delivery = $order->delivery()->select([
            'id',
            'order_id',
            'status',
            DB::raw("ST_X(current_location) AS lng"),  // x -> lng
            DB::raw("ST_Y(current_location) AS lat"),  // y -> lat
        ])->first();

        return view('front.order.delivery.show', compact('order', 'delivery'));
    }
}
