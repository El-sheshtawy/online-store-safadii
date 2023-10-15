<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\CartRepositoryInterface;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Product;


class CartController extends Controller
{
    protected CartRepositoryInterface $cart;

    public function __construct(CartRepositoryInterface $cart)
    {
        $this->cart = $cart;
    }
    public function index()
    {
        $items = $this->cart->get();
        return view('front.cart.cart',compact('items'));
    }

    public function store(StoreCartRequest $request)
    {
        $product = Product::findOrFail($request->post('product_id'));
        $this->cart->add($product, $request->post('quantity'));
        if ($request->expectsJson()){
            return response()->json([
                'message'=>'Item added to Cart',
            ]);
        }
        return redirect()->route('cart.index')->with('success','product added to cart');
    }

    public function update(UpdateCartRequest $request, $id)
    {
        $this->cart->update($id, $request->post('quantity'));
    }

    public function destroy(string $id)
    {
        $this->cart->delete($id);
    }
}
