<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreatedEvent;
use App\Exceptions\InvalidOrderException;
use App\Http\Controllers\Controller;
use App\Http\Facades\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;

class OrderController extends Controller
{

    public function create()
    {
        if (Cart::get()->count() == 0) {
            throw new InvalidOrderException('Cart is empty');
        }
        return view('front.order.create', [
            'countries' => Countries::getNames(),
        ]);
    }

    public function store(Request $request)
    {
        $carts = Cart::get()->groupBy('Product.store_id')->all();
        try {
            DB::beginTransaction();

            foreach ($carts as $store_id => $cartItems) {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::guard('web')->id(),
                ]);

                foreach ($cartItems as $cart) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cart->product_id,
                        'product_name' => $cart->product->name,
                        'price' => $cart->product->compare_price ?? $cart->product->price,
                        'quantity'=>$cart->quantity,
                        'payment_method' => 'Cash on Delivery',
                    ]);
                }
                foreach ($request->post('address') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }
            }
            DB::commit();
            event(new OrderCreatedEvent($order));
        }
        catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
        return redirect()->to('/pay/order/card/stripe');
    }
}
