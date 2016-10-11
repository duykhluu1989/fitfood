@extends('admin.layouts.main')

@section('title', 'Edit Meal Pack')

@section('header', 'Edit Meal Pack - ' . $mealPack->name)

@section('content')

    <form method="post" action="{{ url('mealPack/edit', ['id' => $mealPack->id]) }}" enctype="multipart/form-data">

        @include('admin.menus.forms.meal_pack', ['mealPack' => $mealPack])

    </form>

@stop