@extends('admin.layouts.main')

@section('title', 'New Category')

@section('header', 'New Category')

@section('content')

    <form method="post" action="{{ url('category/create') }}">

        @include('admin.menus.forms.category', ['category' => $category])

    </form>

@stop