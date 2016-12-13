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
                            @if($resources->total() > 0)
                                <input class="CheckboxAllControlForm" type="checkbox" />
                            @endif
                        </th>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Name EN</th>
                        <th>Code</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Calories</th>
                        <th>Carb</th>
                        <th>Fat</th>
                        <th>Protein</th>
                        <th>Active</th>
                    </tr>
                    </thead>
                    <tbody>
                    <form id="FilterForm" action="{{ url('admin/resource') }}" method="get">
                        <tr>
                            <td></td>
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
                            <td></td>
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
                    <form id="ControlForm" action="{{ url('admin/resource/control') }}" method="post">
                        @foreach($resources as $resource)
                            <tr>
                                <td>
                                    <input class="CheckboxControlForm" name="id[]" type="checkbox" value="{{ $resource->id }}" />
                                </td>
                                <td>
                                    <a href="{{ url('admin/resource/edit', ['id' => $resource->id]) }}" class="btn btn-primary btn-outline">{{ $resource->id }}</a>
                                </td>
                                <td>{{ $resource->category->name }}</td>
                                <td>{{ $resource->name }}</td>
                                <td>{{ $resource->name_en }}</td>
                                <td>{{ $resource->code }}</td>
                                <td>{{ App\Libraries\Util::formatMoney($resource->price) }}</td>
                                <td>{{ App\Libraries\Util::formatMoney($resource->quantity) . ' ' . $resource->unit->name }}</td>
                                <td>{{ App\Libraries\Util::formatMoney($resource->calories) }}</td>
                                <td>{{ App\Libraries\Util::formatMoney($resource->carb) }}</td>
                                <td>{{ App\Libraries\Util::formatMoney($resource->fat) }}</td>
                                <td>{{ App\Libraries\Util::formatMoney($resource->protein) }}</td>
                                <td<?php echo ($resource->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?>></td>
                            </tr>
                        @endforeach

                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    </form>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $resources])
            </div>
        </div>
    </div>

@stop