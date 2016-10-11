@extends('admin.layouts.main')

@section('title', 'New User')

@section('header', 'New User')

@section('content')

    <form method="post" action="{{ url('user/create') }}">

        @include('admin.users.forms.user', ['user' => $user])

    </form>

@stop