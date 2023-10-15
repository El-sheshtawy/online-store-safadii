@extends('dashboard.layouts.master')
@section('content')
    <form method="POST" action=" {{ route('admin.products.store') }} " enctype="multipart/form-data">
        @csrf
        @include('dashboard.products._form',[
  'button_name'=>'Save'
])
    </form>
@endsection

@section('page_header')
    Create Product
    <hr>
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Create Product</li>
@endsection

@push('extra_styles')
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
@endpush
@push('extra_scripts')
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css"/>
    <script>
        var inputElm = document.querySelector('[name=tags]'),
            tagify = new Tagify(inputElm);
    </script>
@endpush

