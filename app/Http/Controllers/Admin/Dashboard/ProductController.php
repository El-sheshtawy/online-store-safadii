<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Traits\UploadOneImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use UploadOneImage;

    public function index()
    {
     //   $this->authorize('viewAny', Product::class);

        $request = request();
        $query = Product::query();

        if ($status = $request->query('status')) {
            $query->where('status', '=', $status);
        }
        if ($search = $request->query('search')) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $products = $query->with(['store', 'category'])->latest()->paginate(10);
        return view('dashboard.products.index', compact('products'));
    }


    public function create()
    {
        $this->authorize('create', Product::class);
        return view('dashboard.products.create',[
            'product' => new Product(),
            'parentCategories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Product::class);
        try {
            $admin = Auth::guard('admin')->user();
            DB::beginTransaction();
            $product = Product::create([
                'name' => $request->name,
                'category_id'=>$request->category_id,
                'store_id'=>$admin->store_id ?? null,
                'description' => $request->description,
                'price' => $request->price,
                'compare_price' => $request->compare_price,
                'status' => $request->status,
            ]);

            $product->update([
                'image' => $this->uploadImageDB($request, 'image', $product),
            ]);
            $this->storeImageDisk($request, 'image', 'images/products', 'my-custom');

            $tags = explode(',', $request->post('tags'));
            $tags_ids = [];
            foreach ($tags as $item) {
                $slug = Str::slug($item);
                $tag = Tag::all()->where('slug', $slug)->first();
                if (!$tag) {
                    $tag = Tag::create([
                        'name' => $item,
                        'slug' => $slug,
                    ]);
                }
                $tags_ids[] = $tag->id;
            }
            $product->tags()->attach($tags_ids);

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Added Product Successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('view', $product);
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('update', $product);
        $tags = implode(',',$product->tags()->pluck('name')->toArray());
        $parentCategories = Category::all();
        return view('dashboard.products.edit',compact('product', 'tags','parentCategories'));
    }


    public function update(Request $request, $id)
    {
        try {
            $product = Product::where('id',$id)->first();
            $this->authorize('update', $product);
            $admin = Auth::guard('admin')->user();
            DB::beginTransaction();
            $product->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'store_id' => $admin->store_id,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'price' => $request->price,
                'compare_price' => $request->compare_price,
                'status' => $request->status,
            ]);
            $this->storeImageDisk($request, 'image', 'images/products', 'my-custom');

            $tags = explode(',', $request->post('tags'));
            $tags_ids = [];
            foreach ($tags as $item) {
                $slug = Str::slug($item);
                $tag = Tag::all()->where('slug', $slug)->first();
                if (!$tag) {
                    $tag = Tag::create([
                        'name' => $item,
                        'slug' => $slug,
                    ]);
                }
                $tags_ids[] = $tag->id;
            }
            $product->tags()->sync($tags_ids);

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Product Updated');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }

    public function destroy($id)
    {
        $product = Product::where('id', '=', $id)->first();
        $this->authorize('delete', $product);
        Product::destroy($product->id);
        return redirect()->route('admin.products.index')->with('danger', 'Deleted Category Successfully');
    }

    public function getDeletedItems()
    {
        $this->authorize('viewAny', Product::class);
        $deletedProducts=Product::onlyTrashed()->paginate();
        return view('dashboard.products.deleted_products',compact('deletedProducts'));
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
         $this->authorize('restore', $product);
        $product->restore();
        return redirect()->back()->with('info','Product restored successfully');

    }

    public function forceDelete($id)
    {
        try {
            $product = Product::onlyTrashed()->findOrFail($id);
            $this->authorize('forceDelete', $product);
            DB::beginTransaction();
            $this->removeImageDisk($product, 'image', 'images/products');
            $product->forceDelete();
            DB::commit();
            return redirect()->route('admin.products.deleted')->with('delete','The Product has been deleted forever!');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }
}
