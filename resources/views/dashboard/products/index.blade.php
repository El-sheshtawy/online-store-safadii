@extends('dashboard.layouts.master')
@section('content')
    <div class="form-row">
        <div class="col-md-auto">
            @can('create','App\Models\Product')
                <a href="{{ route('admin.products.create') }}" class="btn btn-warning">Add Product</a><br><br>
            @endcan
        </div>
        <div class="col-md-auto">
            <a href="{{ route('admin.products.deleted') }}" class="btn btn-dark">Deleted Products</a><br><br>
        </div>
    </div>
    @isset($products)
        @if($products->isNotEmpty())
            <form method="GET" action={{ URL::current() }}>
                @csrf
                <select name="status" class="form-control">
                    <option value="">All</option>
                    <option value="active" @selected(request('active') == 'active')>Active</option>
                    <option value="archived" @selected(request('archived') == 'archived')>Archived</option>
                </select>
                <x-form.input class="form-control" name="search" type="text" placeholder="Search"
                              value="{{ request('search') }}"/>
                <x-form.button class="btn btn-success" button_name="search"/>
            </form>
            <br>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Category</th>
                    <th scope="col">Store</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Status</th>
                    <th style="text-align: center;" colspan="2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{!!   $product->escapedDescription !!}</td>
                        <td>
                            <img src="/images/products/{{ $product->image }}" alt="image not found" height="50px">
                        </td>
                        <td> {{  $product->category ? $product->category->name : '-' }}</td>

                        <td>{{ $product->store ? $product->store->name : '' }}</td>

                        <td>{{ $product->created_at }}</td>
                        <td>
                            @if($product->status=='active')
                                <h6 style="font-weight: bold;color: green"> {{ $product->status }} </h6>
                            @elseif($product->status=='archived')
                                <h6 style="font-weight: bold;color: red"> {{ $product->status }} </h6>

                            @elseif($product->status=='draft')
                                <h6 style="font-weight: bold;color: #6a0d6a"> {{ $product->status }} </h6>
                            @endif
                        </td>
                        @can('products.update')
                            <td>
                                <a href="{{ route('admin.products.edit',$product->id) }}"
                                   class="btn btn-primary">Edit</a>
                            </td>
                        @endcan
                        @can('delete',$product)
                            <td>
                                <form action="{{ route('admin.products.destroy',$product->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        @endcan
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $products->withQueryString()->appends(['result'=>'success'])->links() }}
        @else
            <br>
            <h1>No products to show</h1>
        @endisset
    @endif
@endsection

@section('page_header')
    Products
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection


