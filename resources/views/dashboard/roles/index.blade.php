@extends('dashboard.layouts.master')
@section('content')
    <x-alert/>
    @can('create','App\Models\Role')
        <a href="{{ route('admin.roles.create') }}" class="btn btn-warning">Add Role</a><br><br>
    @endcan

    <input type="text" class="form-control" name="search" id="search" placeholder="Search here">
    <br>
    <div class="roles-table">
        @if($roles->isNotEmpty())
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th>Created at</th>
                    <th style="text-align: center;" colspan="2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->created_at->format('l, jS \of F Y, h:i:s A')}}</td>
                        @can('update',$role)
                            <td>
                                <a href="{{ route('admin.roles.edit',$role->id) }}" class="btn btn-primary">Edit</a>
                            </td>
                        @endcan

                        @can('delete',$role)
                            <td>
                                <form action="{{ route('admin.roles.destroy',$role->id) }}" method="POST">
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
            {{ $roles->withQueryString()->links() }}

        @else
            <br>
            <h1>The roles is empty now</h1>
        @endif
    </div>
@endsection

@section('page_header')
    Roles
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>
@endsection

@include('dashboard.roles.ajax_script')
