@extends('admin.layouts.main')

@section('title', 'Edit Resource')

@section('header', 'Edit Resource - ' . $resource->name)

@section('content')

    <form method="post" action="{{ url('admin/resource/edit', ['id' => $resource->id]) }}">

        @include('admin.menus.forms.resource', ['resource' => $resource])

    </form>

@stop