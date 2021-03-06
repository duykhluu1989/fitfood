@extends('admin.layouts.main')

@section('title', 'List Widget')

@section('header', 'List Widget')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $widgets])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/widget/create') }}" data-toggle="tooltip" title="New Widget" class="btn btn-primary btn-outline">
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
                        <th>Type</th>
                        <th>Active</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/widget') }}" method="get">
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[name]" value="{{ (isset($filter['name']) ? $filter['name'] : '') }}" />
                            </td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[type]">
                                    <option value=""></option>
                                    @foreach(App\Libraries\Util::getWidgetType() as $value => $label)
                                        @if(isset($filter['type']) && $filter['type'] !== '' && $filter['type'] == $value)
                                            <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[status]">
                                    <option value=""></option>
                                    @foreach(App\Libraries\Util::getStatus() as $value => $label)
                                        @if(isset($filter['status']) && $filter['status'] !== '' && $filter['status'] == $value)
                                            <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        <input type="submit" style="display: none" />
                    </form>
                    </thead>
                    <tbody>
                    @foreach($widgets as $widget)
                        <tr>
                            <td>
                                <a href="{{ url('admin/widget/edit', ['id' => $widget->id]) }}" class="btn btn-primary btn-outline">{{ $widget->id }}</a>
                            </td>
                            <td>{{ $widget->name }}</td>
                            <td>{{ App\Libraries\Util::getWidgetType($widget->type) }}</td>
                            <td<?php echo ($widget->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?>></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $widgets])
            </div>
        </div>
    </div>

@stop