@extends('admin.layouts.main')

@section('title', 'New Role')

@section('header', 'New Role')

@section('content')

    <form method="post" action="{{ url('admin/role/create') }}">

        @include('admin.users.forms.role', ['role' => $role])

    </form>

@stop