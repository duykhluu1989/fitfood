@extends('admin.layouts.main')

@section('title', 'New Menu')

@section('header', 'New Menu')

@section('content')

    <form method="post" action="{{ url('admin/menu/create') }}" enctype="multipart/form-data">

        @include('admin.menus.forms.menu', ['menu' => $menu])

    </form>

@stop