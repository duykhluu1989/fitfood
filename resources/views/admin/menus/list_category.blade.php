@extends('admin.layouts.main')

@section('title', 'List Category')

@section('header', 'List Category')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $categories])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/category/create') }}" data-toggle="tooltip" title="New Category" class="btn btn-primary btn-outline">
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
                            @if($categories->total() > 0)
                                <input class="CheckboxAllControlForm" type="checkbox" />
                            @endif
                        </th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Active</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/category') }}" method="get">
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
                    <form id="ControlForm" action="{{ url('admin/category/control') }}" method="post">
                        @foreach($categories as $category)
                            <tr>
                                <td>
                                    <input class="CheckboxControlForm" name="id[]" type="checkbox" value="{{ $category->id }}" />
                                </td>
                                <td>
                                    <a href="{{ url('admin/category/edit', ['id' => $category->id]) }}" class="btn btn-primary btn-outline">{{ $category->id }}</a>
                                </td>
                                <td>{{ $category->name }}</td>
                                <td<?php echo ($category->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?>></td>
                            </tr>
                        @endforeach

                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    </form>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $categories])
            </div>
        </div>
    </div>

@stop