@extends('admin.layouts.main')

@section('title', 'Edit Unit')

@section('header', 'Edit Unit - ' . $unit->name)

@section('content')

    <form method="post" action="{{ url('admin/unit/edit', ['id' => $unit->id]) }}">

        @include('admin.menus.forms.unit', ['unit' => $unit])

    </form>

@stop