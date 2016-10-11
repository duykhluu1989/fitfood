@extends('admin.layouts.main')

@section('title', 'New Resource')

@section('header', 'New Resource')

@section('content')

    <form method="post" action="{{ url('resource/create') }}">

        @include('admin.menus.forms.resource', ['resource' => $resource])

    </form>

@stop