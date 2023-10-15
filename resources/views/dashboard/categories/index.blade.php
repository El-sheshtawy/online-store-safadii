@extends('dashboard.layouts.master')
@section('content')
    <x-alert/>
    @if(Auth::user()->can('categories.create'))
        <a href="{{ route('admin.categories.create') }}" class="btn btn-warning">Add Category</a><br><br>
    @endif

    @if($categories->isNotEmpty())

        <form method="GET" action={{ URL::current() }}>
            @csrf
            <select name="status" class="form-control">
                <option value="">All</option>
                <option value="active" @selected(request('status') == 'active')>Active</option>
                <option value="archived" @selected(request('status') == 'archived')>Archived</option>
            </select>
            <input class="form-control" name="search" type="text" placeholder="Search here"
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-success">Search</button>
        </form><br>


        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Parent Category</th>
                <th scope="col">Created Date</th>
                <th scope="col">Status</th>
                <th scope="col">Products number</th>
                <th style="text-align: center;" colspan="3">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>

                    <td>{{ $category->name }}</td>

                    <td>
                        <img src="/images/categories/{{ $category->image }}" alt="image not found" height="50px">
                    </td>

                    <td>
                        {{ $category->parent_id ? $category->mainCategory->name : '' }}
                    </td>

                    <td>{{ $category->created_at->format('l, jS \of F Y, h:i:s A')}}</td>

                    <td>
                        @if($category->status=='active')
                            <h6 style="font-weight: bold;color: green"> {{ $category->status }} </h6>
                        @elseif($category->status=='archived')
                            <h6 style="font-weight: bold;color: red"> {{ $category->status }} </h6>
                        @endif
                    </td>

                    <td> {{ $category->products_count }} </td>


                    @can('categories.update')
                        <td>
                            <a href="{{ route('admin.categories.edit',$category->id) }}"
                               class="btn btn-primary">Edit</a>
                        </td>
                    @endcan


                    <td>
                        <a href="{{ route('admin.categories.show',$category->id) }}"
                           class="btn btn-secondary">
                            Products
                        </a>
                    </td>

                    @can('categories.delete')
                        <td>
                            <form action="{{ route('admin.categories.destroy',$category->id) }}" method="POST">
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
        {{ $categories->withQueryString()->appends(['pages'=>'categories'])->links() }}
    @else
        <br>
        <h1>The categories is empty now</h1>
    @endif
@endsection

@section('page_header')
    Categories
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection


