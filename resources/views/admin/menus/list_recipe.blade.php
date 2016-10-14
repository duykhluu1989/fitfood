@extends('admin.layouts.main')

@section('title', 'List Recipe')

@section('header', 'List Recipe')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $recipes])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/recipe/create') }}" data-toggle="tooltip" title="New Recipe" class="btn btn-primary btn-outline">
                            <i class="fa fa-plus fa-fw"></i>
                        </a>
                        <a href="{{ url('admin/recipe/export?' . $queryString) }}" data-toggle="tooltip" title="Export Excel" class="btn btn-primary btn-outline">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Name EN</th>
                        <th>Resource</th>
                        <th>Resource EN</th>
                        <th>Resource Quantity</th>
                        <th>Resource Price</th>
                        <th>Recipe Price</th>
                        <th>Active</th>
                    </tr>
                    </thead>
                    <tbody>
                    <form id="FilterForm" action="{{ url('admin/recipe') }}" method="get">
                        <tr>
                            <td></td>
                            <td>
                                <input class="form-control" name="filter[name]" value="{{ (isset($filter['name']) ? $filter['name'] : '') }}" />
                            </td>
                            <td>
                                <input class="form-control" name="filter[name_en]" value="{{ (isset($filter['name_en']) ? $filter['name_en'] : '') }}" />
                            </td>
                            <td>
                                <input class="form-control" name="filter[resource]" value="{{ (isset($filter['resource']) ? $filter['resource'] : '') }}" />
                            </td>
                            <td>
                                <input class="form-control" name="filter[resource_en]" value="{{ (isset($filter['resource_en']) ? $filter['resource_en'] : '') }}" />
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <input type="submit" style="display: none" />
                    </form>
                    @foreach($recipes as $recipe)
                        <?php
                        $countResource = count($recipe->recipeResources);
                        ?>
                        @for($i = 0;$i < $countResource;$i ++)
                            @if($i == 0)
                                <tr>
                                    <td rowspan="{{ $countResource }}">
                                        <a href="{{ url('admin/recipe/edit', ['id' => $recipe->id]) }}" class="btn btn-primary btn-outline">{{ $recipe->id }}</a>
                                    </td>
                                    <td rowspan="{{ $countResource }}">{{ $recipe->name }}</td>
                                    <td rowspan="{{ $countResource }}">{{ $recipe->name_en }}</td>
                                    <td>{{ $recipe->recipeResources[$i]->resource->name }}</td>
                                    <td>{{ $recipe->recipeResources[$i]->resource->name_en }}</td>
                                    <td>{{ App\Libraries\Util::formatMoney($recipe->recipeResources[$i]->quantity) . ' ' . $recipe->recipeResources[$i]->resource->unit->name }}</td>
                                    <td>{{ App\Libraries\Util::formatMoney($recipe->recipeResources[$i]->price) }}</td>
                                    <td rowspan="{{ $countResource }}">{{ App\Libraries\Util::formatMoney($recipe->price) }}</td>
                                    <td<?php echo ($recipe->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?> rowspan="{{ $countResource }}"></td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $recipe->recipeResources[$i]->resource->name }}</td>
                                    <td>{{ $recipe->recipeResources[$i]->resource->name_en }}</td>
                                    <td>{{ $recipe->recipeResources[$i]->quantity . ' ' . $recipe->recipeResources[$i]->resource->unit->name }}</td>
                                    <td>{{ App\Libraries\Util::formatMoney($recipe->recipeResources[$i]->price) }}</td>
                                </tr>
                            @endif
                        @endfor
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $recipes])
            </div>
        </div>
    </div>

@stop