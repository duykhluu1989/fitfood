@extends('admin.layouts.main')

@section('title', 'New Tag')

@section('header', 'New Tag')

@section('content')

    <form method="post" action="{{ url('admin/tag/create') }}">

        @include('admin.blogs.forms.tag', ['tag' => $tag])

    </form>

@stop