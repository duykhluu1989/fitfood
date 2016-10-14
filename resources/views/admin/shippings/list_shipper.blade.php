@extends('admin.layouts.main')

@section('title', 'List Shipper')

@section('header', 'List Shipper')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $shippers])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/shipper/create') }}" data-toggle="tooltip" title="New Shipper" class="btn btn-primary btn-outline">
                            <i class="fa fa-plus fa-fw"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Active</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($shippers as $shipper)
                        <tr>
                            <td>
                                <a href="{{ url('admin/shipper/edit', ['id' => $shipper->id]) }}" class="btn btn-primary btn-outline">{{ $shipper->id }}</a>
                            </td>
                            <td>{{ $shipper->name }}</td>
                            <td>{{ $shipper->phone }}</td>
                            <td<?php echo ($shipper->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?>></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $shippers])
            </div>
        </div>
    </div>

@stop