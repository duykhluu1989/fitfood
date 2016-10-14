@extends('admin.layouts.main')

@section('title', 'New Unit')

@section('header', 'New Unit')

@section('content')

    <form method="post" action="{{ url('admin/unit/create') }}">

        @include('admin.menus.forms.unit', ['unit' => $unit])

    </form>

@stop