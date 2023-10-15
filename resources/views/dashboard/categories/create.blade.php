@extends('dashboard.layouts.master')

@section('content')

    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
        @csrf
        @include('dashboard.categories._form',[
     'button_name'=>'Save'
 ])

    </form>

@endsection

@section('page_header')
    Add Category
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Add Category</li>
@endsection


