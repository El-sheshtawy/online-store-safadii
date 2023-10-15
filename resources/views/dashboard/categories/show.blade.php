@extends('dashboard.layouts.master')
@section('content')
    @isset($category->products)
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Store</th>
                <th scope="col">Status</th>
                <th scope="col">Created Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products = $category->products()->with('store')->paginate(10) as $product)
                <tr>
                    <td>{{ $product->name }}</td>

                    <td> {{  $product->category ? $product->category->name : '-' }}</td>

                    <td>{{ $product->store ? $product->store->name : '' }}</td>

                    <td>
                        @if($product->status=='active')
                            <h6 style="font-weight: bold;color: green"> {{ $product->status }} </h6>
                        @elseif($product->status=='archived')
                            <h6 style="font-weight: bold;color: red"> {{ $product->status }} </h6>
                        @endif
                    </td>
                    <td>{{ $product->created_at->format('l, jS \of F Y, h:i:s A')}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $products->links() }}
    @else
        No Products to show
    @endisset

@endsection

@section('page_header')
    Show Products Related Category
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Show Products Related Category</li>
@endsection

