@extends('dashboard.layouts.master')
@section('content')
    <form method="POST" action="{{ route('admin.admins.store') }}"
          enctype="multipart/form-data">
        @csrf
        @include('dashboard.admins._form',[
     'button_name'=>'Save'
 ])
    </form>

@endsection

@section('page_header')
    Add Admin
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Add Admin</li>
@endsection

