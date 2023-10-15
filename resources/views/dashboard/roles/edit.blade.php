@extends('dashboard.layouts.master')
@section('content')

    <form method="POST" action="{{ route('admin.roles.update',$role->id) }}" enctype="multipart/form-data">
        @csrf
        @method('put')
      @include('dashboard.roles._form', [
    'button_name'=>'Update'
])
    </form>
@endsection

@section('page_header')
    Edit Role
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Role</li>
@endsection

