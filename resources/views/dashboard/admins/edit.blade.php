@extends('dashboard.layouts.master')
@section('content')
    <form method="POST" action="{{ route('admin.admins.update',$admin->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('dashboard.admins._form',[
      'button_name'=>'Update'
  ])
    </form>
@endsection

@section('page_header')
    Edit Admin
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Admin</li>
@endsection

