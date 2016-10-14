@extends('admin.layouts.main')

@section('stylesheet')

    <link href="{{ asset('assets/css/jquery.tag-editor.css') }}" rel="stylesheet">

@stop

@section('title', 'New Article')

@section('header', 'New Article')

@section('content')

    <form method="post" action="{{ url('admin/article/create') }}" enctype="multipart/form-data">

        @include('admin.blogs.forms.article', ['article' => $article])

    </form>

@stop