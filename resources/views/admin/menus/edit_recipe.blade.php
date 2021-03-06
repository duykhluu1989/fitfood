@extends('admin.layouts.main')

@section('title', 'Edit Recipe')

@section('header', 'Edit Recipe - ' . $recipe->name)

@section('content')

    <form method="post" action="{{ url('admin/recipe/edit', ['id' => $recipe->id]) }}" enctype="multipart/form-data">

        @include('admin.menus.forms.recipe', ['recipe' => $recipe])

    </form>

@stop