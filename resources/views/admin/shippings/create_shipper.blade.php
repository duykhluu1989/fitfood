@extends('admin.layouts.main')

@section('title', 'New Shipper')

@section('header', 'New Shipper')

@section('content')

    <form method="post" action="{{ url('shipper/create') }}">

        @include('admin.shippings.forms.shipper', ['shipper' => $shipper])

    </form>

@stop