@extends('admin.layouts.main')

@section('title', 'Edit Banner')

@section('header', 'Edit Banner - ' . $banner->name)

@section('content')

    <form method="post" action="{{ url('admin/banner/edit', ['id' => $banner->id]) }}" enctype="multipart/form-data">

        @include('admin.customers.forms.banner', ['banner' => $banner])

    </form>

@stop