@extends('admin.layouts.main')

@section('title', 'Edit Category')

@section('header', 'Edit Category - ' . $category->name)

@section('content')

    <form method="post" action="{{ url('blogCategory/edit', ['id' => $category->id]) }}" enctype="multipart/form-data">

        @include('admin.blogs.forms.category', ['category' => $category])

    </form>

@stop