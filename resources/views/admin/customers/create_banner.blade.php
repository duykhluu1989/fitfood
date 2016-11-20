@extends('admin.layouts.main')

@section('title', 'New Banner')

@section('header', 'New Banner')

@section('content')

    <form method="post" action="{{ url('admin/banner/create') }}" enctype="multipart/form-data">

        @include('admin.customers.forms.banner', ['banner' => $banner])

    </form>

@stop