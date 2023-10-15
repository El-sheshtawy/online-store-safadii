<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Traits\UploadOneImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use UploadOneImage;

    public function index()
    {
        if (Gate::denies('categories.view')) {
            abort(403);
        }
        $request = request();
        $query = Category::query();

        if ($status = $request->query('status')) {
            $query->where('status','=',$status);
        }

        if ($search = $request->query('search')) {
            $query->where('name', "LIKE", "%".$search."%");
        }

        $categories = $query->with(['mainCategory','childCategories'])->withCount([
                'products' => function($query) {
                $query->where('status','=','active');
                }
            ])
            ->paginate();

        return view('dashboard.categories.index',compact('categories'));
    }

    public function create()
    {
        if (!Gate::allows('categories.create')) {
            abort(403);
        }
        $parentCategories = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('parentCategories', 'category'));
    }


    public function store(StoreCategoryRequest $request)
    {
        Gate::authorize('categories.create');
        try {
            DB::beginTransaction();
            $category = Category::create([
                'name' => ucfirst(strtolower($request->post('name'))),
                'parent_id' => $request->post('parent_id'),
                'description' => ucfirst(strtolower($request->post('description'))),
                'status' => $request->post('status'),
                'slug' => Str::slug($request->post('name')),
            ]);
            $category->update([
                'image' => $this->uploadImageDB($request, 'image', $category),
            ]);
            $this->storeImageDisk($request, 'image', 'images/categories', 'my-custom');
            DB::commit();
            return redirect()->route('admin.categories.index')->with('success', 'Added Category Successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception;
        }
    }

    public function show($id)
    {
        if (Gate::denies('categories.view')) {
            abort(403);
        }
        $category = Category::where('id',$id)->first();
        return view('dashboard.categories.show', compact('category'));
    }

    public function edit($id)
    {
        if (Gate::denies('categories.update')) {
            abort(403);
        }
        $category = Category::where('id', $id)->first();

        if (!$category) {
            return 'Not found category';
        }

        $parentCategories = Category::where('id', '<>', $id)->where(function ($query) use ($id) {
            $query->whereNull('parent_id')->orWhere('parent_id', '<>', $id);
        })->get();

        return view('dashboard.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        Gate::authorize('categories.update');
        try {
            DB::beginTransaction();
            $category = Category::where('id', $id)->first();
            $category->update([
                'name' => ucfirst(strtolower($request->name)),
                'parent_id' => $request->parent_id,
                'description' => ucfirst(strtolower($request->description)),
                'status' => $request->status,
            ]);
            $this->removeImageDisk($category, 'image', 'images/categories');
            $category->update([
                'image' => $this->uploadImageDB($request, 'image', $category),
            ]);
            $this->storeImageDisk($request, 'image', 'images/categories', 'my-custom');
            DB::commit();
            return redirect()->route('admin.categories.index')->with('success', 'Updated Category Successfully');
        } catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
        }
    }

    public function destroy($id)
    {
        Gate::authorize('categories.delete');
        try {
            $category = Category::where('id', $id)->first();
            DB::beginTransaction();
            $this->removeImageDisk($category, 'image','images/categories');
            Category::destroy($id);
            DB::commit();
            return redirect()
                ->route('admin.categories.index')
                ->with('danger', 'Deleted Category Successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
        }
    }
}