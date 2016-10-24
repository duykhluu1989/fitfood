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
                        <a href="{{ url('admin/blogCategory/create') }}" data-toggle="tooltip" title="New Category" class="btn btn-primary btn-outline">
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
                        <th>Name EN</th>
                        <th>Slug</th>
                        <th>Slug EN</th>
                        <th>Active</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/blogCategory') }}" method="get">
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[name]" value="{{ (isset($filter['name']) ? $filter['name'] : '') }}" />
                            </td>
                            <td>
                                <input type="text" class="form-control" name="filter[name_en]" value="{{ (isset($filter['name_en']) ? $filter['name_en'] : '') }}" />
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
                    @foreach($categories as $category)
                        <tr>
                            <td>
                                <a href="{{ url('admin/blogCategory/edit', ['id' => $category->id]) }}" class="btn btn-primary btn-outline">{{ $category->id }}</a>
                            </td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->name_en }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->slug_en }}</td>
                            <td<?php echo ($category->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?>></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $categories])
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