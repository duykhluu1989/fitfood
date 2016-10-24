@extends('admin.layouts.main')

@section('title', 'List Role')

@section('header', 'List Role')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $roles])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/role/create') }}" data-toggle="tooltip" title="New Role" class="btn btn-primary btn-outline">
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
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/role') }}" method="get">
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[name]" value="{{ (isset($filter['name']) ? $filter['name'] : '') }}" />
                            </td>
                        </tr>

                        <input type="submit" style="display: none" />
                    </form>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>
                                <a href="{{ url('admin/role/edit', ['id' => $role->id]) }}" class="btn btn-primary btn-outline">{{ $role->id }}</a>
                            </td>
                            <td>{{ $role->name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $roles])
            </div>
        </div>
    </div>

@stop