@extends('admin.layouts.main')

@section('title', 'Edit Tag')

@section('header', 'Edit Tag - ' . $tag->name)

@section('content')

    <form method="post" action="{{ url('admin/tag/edit', ['id' => $tag->id]) }}">

        @include('admin.blogs.forms.tag', ['tag' => $tag])

    </form>

@stop