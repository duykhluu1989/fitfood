@extends('admin.layouts.main')

@section('title', 'List Unit')

@section('header', 'List Unit')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $units])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('unit/create') }}" data-toggle="tooltip" title="New Unit" class="btn btn-primary btn-outline">
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
                        <th>Active</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($units as $unit)
                        <tr>
                            <td>
                                <a href="{{ url('unit/edit', ['id' => $unit->id]) }}" class="btn btn-primary btn-outline">{{ $unit->id }}</a>
                            </td>
                            <td>{{ $unit->name }}</td>
                            <td<?php echo ($unit->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?>></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $units])
            </div>
        </div>
    </div>

@stop