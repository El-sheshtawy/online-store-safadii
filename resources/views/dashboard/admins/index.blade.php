@extends('dashboard.layouts.master')
@section('content')
    <x-alert/>
    <a href="{{ route('admin.admins.create') }}" class="btn btn-warning">Add Admin</a><br><br>
    <input type="text" class="form-control" name="search" id="search" placeholder="Search here">
    <div class="admin-table">
        @if($admins->isNotEmpty())
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Created at</th>
                </tr>
                </thead>
                <tbody>
                @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td>
                            <a style="color: red" href="{{ route('admin.admins.edit', $admin->id) }}">
                                {{ $admin->name }}
                            </a>
                        </td>
                        <td>{{ $admin->email }}</td>
                        <td>

                        </td>
                        <td>{{ $admin->created_at->format('d/m/Y ,  h:i:s A')}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $admins->withQueryString()->links() }}

        @else
            <br>
            <h1>The roles is empty now</h1>
        @endif
    </div>
@endsection

@section('page_header')
    Admins
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Admins</li>
@endsection

@include('dashboard.admins.ajax_script')
