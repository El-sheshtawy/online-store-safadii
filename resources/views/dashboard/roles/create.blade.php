@extends('dashboard.layouts.master')
@section('content')
   <form method="POST" action="{{ route('admin.roles.store') }}" enctype="multipart/form-data">
       @csrf
       @include('dashboard.roles._form',[
    'button_name'=>'Save'
])
   </form>
@endsection

@section('page_header')
    Add Role
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Add Role</li>
@endsection
