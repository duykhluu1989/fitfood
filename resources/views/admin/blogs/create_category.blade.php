@extends('admin.layouts.main')

@section('title', 'New Category')

@section('header', 'New Category')

@section('content')

    <form method="post" action="{{ url('admin/blogCategory/create') }}" enctype="multipart/form-data">

        @include('admin.blogs.forms.category', ['category' => $category])

    </form>

@stop