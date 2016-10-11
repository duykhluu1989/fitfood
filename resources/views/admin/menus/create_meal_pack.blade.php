@extends('admin.layouts.main')

@section('title', 'New Meal Pack')

@section('header', 'New Meal Pack')

@section('content')

    <form method="post" action="{{ url('mealPack/create') }}" enctype="multipart/form-data">

        @include('admin.menus.forms.meal_pack', ['mealPack' => $mealPack])

    </form>

@stop