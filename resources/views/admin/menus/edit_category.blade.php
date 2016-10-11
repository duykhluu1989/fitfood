@extends('admin.layouts.main')

@section('title', 'Edit Category')

@section('header', 'Edit Category - ' . $category->name)

@section('content')

    <form method="post" action="{{ url('category/edit', ['id' => $category->id]) }}">

        @include('admin.menus.forms.category', ['category' => $category])

    </form>

@stop