@extends('admin.layouts.main')

@section('title', 'Edit District')

@section('header', 'Edit District - ' . $area->name)

@section('content')

    <form method="post" action="{{ url('admin/area/edit', ['id' => $area->id]) }}">

        @include('admin.shippings.forms.area', ['area' => $area])

    </form>

@stop