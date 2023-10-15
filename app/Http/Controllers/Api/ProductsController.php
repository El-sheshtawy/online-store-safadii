<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $products = Product::filter($request->query())
            ->with('category:id,name', 'store:id,name', 'tags:id,name')
            ->paginate();

        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['string', 'required', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'store_id' => ['required', 'exists:stores,id'],
            'status' => ['in:active,inactive'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'gt:price'],
        ]);

        $product = Product::create($request->all());

        return response()->json($product,201,[
            'Location' => route('product.show',$product->id),
        ]);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
//        return $product->load('category:id,name', 'store:id,name', 'tags:id,name');
    }

  public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => ['string', 'sometimes', 'required', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'category_id' => ['sometimes', 'required', 'exists:categories,id'],
            'store_id' => ['sometimes', 'required', 'exists:stores,id'],
            'status' => ['in:active,inactive'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'gt:price'],
        ]);
        abort_if(! $request->user()->tokenCan('products.update'), 403);
        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        abort_if(! auth()->guard('sanctum')->user()->tokenCan('products.destroy'), 403);
        $product->delete();
        return response()->json([
            'message' => 'Product deleted Successfully',
        ],200);  //response()->json(null, 204);
    }
}
