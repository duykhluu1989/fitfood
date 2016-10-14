@extends('admin.layouts.main')

@section('title', 'Edit User')

@section('header', 'Edit User - ' . $user->username)

@section('content')

    <form method="post" action="{{ url('admin/user/edit', ['id' => $user->id]) }}">

        @include('admin.users.forms.user', ['user' => $user])

    </form>

@stop