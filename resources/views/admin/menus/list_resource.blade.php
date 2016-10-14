@extends('admin.layouts.main')

@section('title', 'List Resource')

@section('header', 'List Resource')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $resources])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/resource/create') }}" data-toggle="tooltip" title="New Resource" class="btn btn-primary btn-outline">
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
                        <th>Category</th>
                        <th>Name</th>
                        <th>Name EN</th>
                        <th>Code</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Active</th>
                    </tr>
                    </thead>
                    <tbody>
                    <form id="FilterForm" action="{{ url('admin/resource') }}" method="get">
                        <tr>
                            <td></td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[category]">
                                    <option value=""></option>
                                    @foreach(App\Models\Category::getModelActiveCategory() as $category)
                                        <option{{ ((isset($filter['category']) && $filter['category'] == $category->id) ? ' selected="selected"' : '') }} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input class="form-control" name="filter[name]" value="{{ (isset($filter['name']) ? $filter['name'] : '') }}" />
                            </td>
                            <td>
                                <input class="form-control" name="filter[name_en]" value="{{ (isset($filter['name_en']) ? $filter['name_en'] : '') }}" />
                            </td>
                            <td>
                                <input class="form-control" name="filter[code]" value="{{ (isset($filter['code']) ? $filter['code'] : '') }}" />
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <input type="submit" style="display: none" />
                    </form>
                    @foreach($resources as $resource)
                        <tr>
                            <td>
                                <a href="{{ url('admin/resource/edit', ['id' => $resource->id]) }}" class="btn btn-primary btn-outline">{{ $resource->id }}</a>
                            </td>
                            <td>{{ $resource->category->name }}</td>
                            <td>{{ $resource->name }}</td>
                            <td>{{ $resource->name_en }}</td>
                            <td>{{ $resource->code }}</td>
                            <td>{{ App\Libraries\Util::formatMoney($resource->price) }}</td>
                            <td>{{ App\Libraries\Util::formatMoney($resource->quantity) . ' ' . $resource->unit->name }}</td>
                            <td<?php echo ($resource->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?>></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $resources])
            </div>
        </div>
    </div>

@stop

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('.DropDownFilterForm').change(function() {

                $('#FilterForm').submit();

            });

        });

    </script>

@stop