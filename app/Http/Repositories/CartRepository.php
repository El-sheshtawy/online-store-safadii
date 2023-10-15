<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\CartRepositoryInterface;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartRepository implements CartRepositoryInterface
{
    protected $items = [];

    public function __construct()
    {
        $this->items = collect([]);
    }

    public function get()
    {
        if ($this->items->count() == 0) {
            $this->items = Cart::with('product')->get();
        }
        return $this->items;
    }

    public function add(Product $product, int $quantity = 1)
    {
        $item = Cart::where('product_id', $product->id)->first();
        if (!$item){
            return Cart::create([
                'user_id'=>Auth::guard('web')->id() ?? null,
                'product_id'=>$product->id,
                'quantity'=>$quantity,
            ]);
        }
        return $item->increment('quantity', $quantity);
    }

    public function update($id, int $quantity)
    {
       return Cart::where('id', $id)->update([
            'quantity' => $quantity,
        ]);
    }

    public function delete($id)
    {
        return Cart::where('id', $id)->delete();
    }

    public function empty()
    {
      Cart::query()->delete();
    }

    public function total() : float
    {
        return $this->get()->sum(function ($item) {
            return $item->quantity * $item->product->compare_price ?? $item->product->price ;
        });
    }

    public function totalByMySql() : float
    {
        return Cart::join('products', 'products.id', 'carts.product_id')
            ->selectRaw('SUM(products.price * carts.quantity) as total')
            ->value('total');
    }
}
