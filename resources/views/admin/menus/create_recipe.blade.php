@extends('admin.layouts.main')

@section('title', 'New Recipe')

@section('header', 'New Recipe')

@section('content')

    <form method="post" action="{{ url('admin/recipe/create') }}">

        @include('admin.menus.forms.recipe', ['recipe' => $recipe])

    </form>

@stop