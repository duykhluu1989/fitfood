@extends('admin.layouts.main')

@section('title', 'Edit Shipper')

@section('header', 'Edit Shipper - ' . $shipper->id)

@section('content')

    <form method="post" action="{{ url('shipper/edit', ['id' => $shipper->id]) }}">

        @include('admin.shippings.forms.shipper', ['shipper' => $shipper])

    </form>

@stop