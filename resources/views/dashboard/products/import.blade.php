@extends('dashboard.layouts.master')
@section('content')

    <form action="{{ route('admin.products.save') }}" method="post" enctype="multipart/form-data">
        @csrf
        <x-form.label>Create products</x-form.label>
        <br>
        <x-form.input name="count" type="number" class="form-control-lg" role="input"/>
        <br><br>
        <x-form.button type="submit" class="btn btn-primary" button_name="Save"></x-form.button>
    </form>

@endsection

@section('page_header')
    Import products
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Admin</li>
@endsection

