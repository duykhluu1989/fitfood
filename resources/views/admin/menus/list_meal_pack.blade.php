@extends('admin.layouts.main')

@section('title', 'List Meal Pack')

@section('header', 'List Meal Pack')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $mealPacks])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/mealPack/create') }}" data-toggle="tooltip" title="New Meal Pack" class="btn btn-primary btn-outline">
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
                        <th>Price</th>
                        <th>Breakfast</th>
                        <th>Lunch</th>
                        <th>Dinner</th>
                        <th>Fruit</th>
                        <th>Veggies</th>
                        <th>Juice</th>
                        <th>Vegetarian</th>
                        <th>Active</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/mealPack') }}" method="get">
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
                    </thead>
                    <tbody>
                    @foreach($mealPacks as $mealPack)
                        <?php
                        $doubles = array();
                        if(!empty($mealPack->double))
                            $doubles = json_decode($mealPack->double, true);
                        ?>
                        <tr>
                            <td>
                                <a href="{{ url('admin/mealPack/edit', ['id' => $mealPack->id]) }}" class="btn btn-primary btn-outline">{{ $mealPack->id }}</a>
                            </td>
                            <td>{{ $mealPack->name }}</td>
                            <td>{{ $mealPack->name_en }}</td>
                            <td>{{ App\Libraries\Util::formatMoney($mealPack->price) }}</td>
                            <td<?php echo ($mealPack->breakfast ? ' class="info"' : ''); ?>>{{ isset($doubles['breakfast']) ? 'Double' : '' }}</td>
                            <td<?php echo ($mealPack->lunch ? ' class="info"' : ''); ?>>{{ isset($doubles['lunch']) ? 'Double' : '' }}</td>
                            <td<?php echo ($mealPack->dinner ? ' class="info"' : ''); ?>>{{ isset($doubles['dinner']) ? 'Double' : '' }}</td>
                            <td<?php echo ($mealPack->fruit ? ' class="info"' : ''); ?>></td>
                            <td<?php echo ($mealPack->veggies ? ' class="info"' : ''); ?>></td>
                            <td<?php echo ($mealPack->juice ? ' class="info"' : ''); ?>></td>
                            <td<?php echo ($mealPack->vegetarian ? ' class="info"' : ''); ?>></td>
                            <td<?php echo ($mealPack->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?>></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $mealPacks])
            </div>
        </div>
    </div>

@stop