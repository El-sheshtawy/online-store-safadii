@extends('dashboard.layouts.master')

@section('content')

    <form method="POST" action="{{ route('admin.categories.update',$category->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('dashboard.categories._form',[
      'button_name'=>'update'
  ])
    </form>

@endsection

@section('page_header')
    Edit Category
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Category</li>
@endsection


