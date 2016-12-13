@extends('admin.layouts.main')

@section('title', 'List Banner')

@section('header', 'List Banner')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $banners])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/banner/create') }}" data-toggle="tooltip" title="New Banner" class="btn btn-primary btn-outline">
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
                        <th>Start</th>
                        <th>End</th>
                        <th>Page</th>
                        <th>Customer Type</th>
                        <th>Active</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/banner') }}" method="get">
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[name]" value="{{ (isset($filter['name']) ? $filter['name'] : '') }}" />
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[page]">
                                    <option value=""></option>
                                    @foreach(App\Libraries\Util::getBannerPage() as $value => $label)
                                        @if(isset($filter['page']) && $filter['page'] == $value)
                                            <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[customer_type]">
                                    <option value=""></option>
                                    @foreach(App\Libraries\Util::getBannerCustomerType() as $value => $label)
                                        @if(isset($filter['customer_type']) && $filter['customer_type'] == $value)
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
                    @foreach($banners as $banner)
                        <tr>
                            <td>
                                <a href="{{ url('admin/banner/edit', ['id' => $banner->id]) }}" class="btn btn-primary btn-outline">{{ $banner->id }}</a>
                            </td>
                            <td>{{ $banner->name }}</td>
                            <td>{{ $banner->start_time }}</td>
                            <td>{{ $banner->end_time }}</td>
                            <td>{{ $banner->page }}</td>
                            <td>{{ $banner->customer_type }}</td>
                            <td<?php echo ($banner->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?>></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $banners])
            </div>
        </div>
    </div>

@stop