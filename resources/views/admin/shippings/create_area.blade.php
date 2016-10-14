@extends('admin.layouts.main')

@section('title', 'New District')

@section('header', 'New District')

@section('content')

    <form method="post" action="{{ url('admin/area/create') }}">

        @include('admin.shippings.forms.area', ['area' => $area])

    </form>

@stop