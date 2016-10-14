@extends('admin.layouts.main')

@section('title', 'Edit Role')

@section('header', 'Edit Role - ' . $role->name)

@section('content')

    <form method="post" action="{{ url('admin/role/edit', ['id' => $role->id]) }}">

        @include('admin.users.forms.role', ['role' => $role])

    </form>

@stop