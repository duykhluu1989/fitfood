@extends('admin.layouts.main')

@section('stylesheet')

    <link href="{{ asset('/../assets/css/jquery.tag-editor.css') }}" rel="stylesheet">

@stop

@section('title', 'Edit Article')

@section('header', 'Edit Article - ' . $article->name)

@section('content')

    <form method="post" action="{{ url('article/edit', ['id' => $article->id]) }}" enctype="multipart/form-data">

        @include('admin.blogs.forms.article', ['article' => $article])

    </form>

@stop