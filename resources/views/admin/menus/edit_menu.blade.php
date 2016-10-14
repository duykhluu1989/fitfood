@extends('admin.layouts.main')

@section('title', 'Edit Menu')

@section('header', 'Edit Menu - ' . $menu->name)

@section('content')

    <form method="post" action="{{ url('admin/menu/edit', ['id' => $menu->id]) }}" enctype="multipart/form-data">

        @include('admin.menus.forms.menu', ['menu' => $menu])

    </form>

@stop