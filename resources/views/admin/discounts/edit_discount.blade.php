@extends('admin.layouts.main')

@section('title', 'Edit Discount')

@section('header', 'Edit Discount - ' . $discount->code)

@section('content')

    <form method="post" action="{{ url('discount/edit', ['id' => $discount->id]) }}">

        @include('admin.discounts.forms.discount', ['discount' => $discount])

    </form>

@stop