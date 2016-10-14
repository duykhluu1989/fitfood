@extends('admin.layouts.main')

@section('title', 'New Discount')

@section('header', 'New Discount')

@section('content')

    <form method="post" action="{{ url('admin/discount/create') }}">

        @include('admin.discounts.forms.discount', ['discount' => $discount])

    </form>

@stop