<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Stripe;

class StripePaymentController extends Controller
{
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
   */
    public function showFormStripe()
    {
        $userId = Auth::guard('web')->id();
        $carts = Cart::where('user_id', $userId)->orWhere('cookie_id', '=', Cart::getCookieId())->get();
        $total_cost = $carts->sum(function ($cart) {
            return $cart->quantity * $cart->product->compare_price ?? $cart->product->price;
        });
            return view('front.order.payment.show-form-payment', compact('total_cost',));
        }

    public function storeStripe(Request $request)
    {
        $userId = Auth::guard('web')->id();
        $carts = Cart::where('user_id', $userId)->orWhere('cookie_id', '=', Cart::getCookieId())->get();
        $total_cost = $carts->sum(function ($cart) {
            return $cart->quantity * $cart->product->compare_price ?? $cart->product->price;
        });
        try {
        DB::beginTransaction();
        Stripe\Stripe::setApiKey(config('services.stripe.secret_key'));
       $transaction = Stripe\Charge::create([
            "amount" => $total_cost * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Test payment from Sheshtawy website",
        ]);
            $userOrders = Order::all()->where('user_id', $userId)->where('payment_status', '<>', 'paid')
                ->groupBy('store_id');

        foreach ($userOrders as $orders) {

         if ($transaction) {
             foreach ($orders as $order) {
                 $success_payment = Payment::create([
                     'order_id' => $order->id,
                     'price' => $order->items->pluck('price')->toArray()[0],
                     'quantity' => $order->items->pluck('quantity')->toArray()[0],
                     'currency' => $transaction->currency,
                     'method' => 'Stripe',
                     'status' => 'completed',
                     'transaction_id' => $transaction->id,
                     'transaction_data' => json_encode($transaction),
                 ]);
                 if ($success_payment) {
                     $order->update([
                         'payment_status' => 'paid',
                     ]);
                     \App\Http\Facades\Cart::empty();
                 }
              }
           }
        }
        DB::commit();
        Session::flash('success', 'Payment successful!');
        return redirect()->route('home')->with('success', 'Success payment');
    } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }
}


