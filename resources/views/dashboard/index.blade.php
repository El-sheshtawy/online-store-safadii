@extends('dashboard.layouts.master')
@section('page_header')
    Dashboard
@endsection
@section('content')
    Hello {{ Auth::guard('admin')->user()->name }}
@endsection
