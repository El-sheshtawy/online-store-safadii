<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
        return 'This will be the page show products';
    }

    public function show(Product $product)
    {
        if ($product->status != 'active'){
            abort(404);
        }
        return view('front.products.show',compact('product'));
    }
}
