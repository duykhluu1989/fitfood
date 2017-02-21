@extends('admin.layouts.main')

@section('title', 'List District')

@section('header', 'List District')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $areas])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/area/create') }}" data-toggle="tooltip" title="New District" class="btn btn-primary btn-outline">
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
                        <th>Price</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/area') }}" method="get">
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[name]" value="{{ (isset($filter['name']) ? $filter['name'] : '') }}" />
                            </td>
                            <td></td>
                            <td></td>
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
                    @foreach($areas as $area)
                        <tr>
                            <td>
                                <a href="{{ url('admin/area/edit', ['id' => $area->id]) }}" class="btn btn-primary btn-outline">{{ $area->id }}</a>
                            </td>
                            <td>{{ $area->name }}</td>
                            <td>{{ App\Libraries\Util::formatMoney($area->shipping_price) }}</td>
                            <td>
                                <?php
                                $shippingTimes = json_decode($area->shipping_time, true);
                                ?>
                                @foreach($shippingTimes as $shippingTime)
                                    {{ $shippingTime }}<br />
                                @endforeach
                            </td>
                            <td<?php echo ($area->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?>></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $areas])
            </div>
        </div>
    </div>

@stop