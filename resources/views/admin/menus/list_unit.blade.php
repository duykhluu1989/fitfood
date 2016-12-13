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
                        <a href="{{ url('admin/unit/create') }}" data-toggle="tooltip" title="New Unit" class="btn btn-primary btn-outline">
                            <i class="fa fa-plus fa-fw"></i>
                        </a>
                        <button value="delete" data-toggle="tooltip" title="Delete" class="btn btn-primary btn-outline ControlButtonControlForm" disabled="disabled">
                            <i class="fa fa-trash-o fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>
                            @if($units->total() > 0)
                                <input class="CheckboxAllControlForm" type="checkbox" />
                            @endif
                        </th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Active</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/unit') }}" method="get">
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[name]" value="{{ (isset($filter['name']) ? $filter['name'] : '') }}" />
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
                    <form id="ControlForm" action="{{ url('admin/unit/control') }}" method="post">
                        @foreach($units as $unit)
                            <tr>
                                <td>
                                    <input class="CheckboxControlForm" name="id[]" type="checkbox" value="{{ $unit->id }}" />
                                </td>
                                <td>
                                    <a href="{{ url('admin/unit/edit', ['id' => $unit->id]) }}" class="btn btn-primary btn-outline">{{ $unit->id }}</a>
                                </td>
                                <td>{{ $unit->name }}</td>
                                <td<?php echo ($unit->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?>></td>
                            </tr>
                        @endforeach

                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    </form>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $units])
            </div>
        </div>
    </div>

@stop