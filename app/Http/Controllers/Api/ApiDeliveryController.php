<?php

namespace App\Http\Controllers\Api;

use App\Events\DeliveryLocationUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryRequest;
use App\Models\Delivery;
use Illuminate\Support\Facades\DB;

class ApiDeliveryController extends Controller
{
    public function show($id)
    {
        $delivery = Delivery::query()->select([
            'id',
            'order_id',
            'status',
            DB::raw("ST_X(current_location) AS lng"),  // x -> lng
            DB::raw("ST_Y(current_location) AS lat"),  // y -> lat
        ])->where('id', $id)->firstOrFail();

        return $delivery;
    }

    public function update(DeliveryRequest $request, Delivery $delivery)
    {
        $delivery->update([
            'current_location' => DB::raw("POINT({$request->lng}, {$request->lat})"),
        ]);

        event(new DeliveryLocationUpdatedEvent($delivery, $request->lat, $request->lng));

        return $delivery;
    }
}