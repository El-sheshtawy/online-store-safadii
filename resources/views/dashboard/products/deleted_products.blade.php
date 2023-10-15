@extends('dashboard.layouts.master')
@section('content')
    )
    <x-alert/>

    <a href="{{ route('admin.products.index') }}" class="btn btn-warning">Products</a><br><br>

    @if($deletedProducts->isNotEmpty())

        <form method="GET" action={{ URL::current() }}>
            @csrf
            <select name="status" class="form-control" style="width: 33.5%">
                <option value="">All</option>
                <option value="active" @selected(request('status') == 'active')>Active</option>
                <option value="archived" @selected(request('status') == 'archived')>Archived</option>
            </select>
            <input name="search" type="text" placeholder="Search here" class="style_search"
                   value="{{ request('search') }}"><br>
            <button type="submit" class="btn btn-success">Search</button>
        </form>

        <br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Category</th>
                <th scope="col">Deleted Date</th>
                <th scope="col">Status</th>
                <th style="text-align: center;" colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($deletedProducts as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        <img src="/images/categories/{{ $product->image }}" alt="image not found" height="50px">
                    </td>
                    <td>
                        @if(!is_null($product->category_id))
                            {{ $product->category->name}}
                        @else

                        @endif
                    </td>
                    <td>{{ $product->deleted_at->format('l, jS \of F Y, h:i:s A')}}</td>
                    <td>
                        @if($product->status=='active')
                            <h6 style="font-weight: bold;color: green"> {{ $product->status }} </h6>
                        @elseif($product->status=='archived')
                            <h6 style="font-weight: bold;color: red"> {{ $product->status }} </h6>

                        @elseif($product->status=='draft')
                            <h6 style="font-weight: bold;color: #6a0d6a"> {{ $product->status }} </h6>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.product.restore',$product->id) }}" class="btn btn-primary">Restore</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.product.force-delete',$product->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Force Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $deletedProducts->withQueryString()->appends(['result'=>'success'])->links() }}
    @else
        <br>
        <h1>The Deleted Products is empty now</h1>
    @endif
@endsection

@section('page_header')
    Deleted Products
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Deleted Products</li>
@endsection


