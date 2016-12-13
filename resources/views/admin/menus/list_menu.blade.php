@extends('admin.layouts.main')

@section('title', 'List Menu')

@section('header', 'List Menu')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $menus])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/menu/create') }}" data-toggle="tooltip" title="New Menu" class="btn btn-primary btn-outline">
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
                            @if($menus->total() > 0)
                                <input class="CheckboxAllControlForm" type="checkbox" />
                            @endif
                        </th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Recipe</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/menu') }}" method="get">
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[name]" value="{{ (isset($filter['name']) ? $filter['name'] : '') }}" />
                            </td>
                            <td></td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[type]">
                                    <option value=""></option>
                                    @foreach(App\Libraries\Util::getMenuType() as $value => $label)
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
                                    @foreach(App\Libraries\Util::getMenuStatus() as $value => $label)
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
                    <form id="ControlForm" action="{{ url('admin/recipe/control') }}" method="post">
                        @foreach($menus as $menu)
                            <tr>
                                <td>
                                    <input class="CheckboxControlForm" name="id[]" type="checkbox" value="{{ $menu->id }}" />
                                </td>
                                <td>
                                    <a href="{{ url('admin/menu/edit', ['id' => $menu->id]) }}" class="btn btn-primary btn-outline">{{ $menu->id }}</a>
                                </td>
                                <td>{{ $menu->name }}</td>
                                <td>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>{{ App\Libraries\Util::MEAL_BREAKFAST_LABEL }}</th>
                                            <th>{{ App\Libraries\Util::MEAL_LUNCH_LABEL }}</th>
                                            <th>{{ App\Libraries\Util::MEAL_DINNER_LABEL }}</th>
                                            <th>Active</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $dayOfWeek = [
                                            1 => 'Monday',
                                            2 => 'Tuesday',
                                            3 => 'Wednesday',
                                            4 => 'Thursday',
                                            5 => 'Friday',
                                        ];
                                        $recipes = array();
                                        foreach($menu->menuRecipes as $menuRecipe)
                                            $recipes[$menuRecipe->day_of_week] = $menuRecipe;
                                        ?>
                                        @for($i = 1;$i <= 5;$i ++)
                                            <tr>
                                                <th>{{ $dayOfWeek[$i] }}</th>
                                                @if(isset($recipes[$i]))
                                                    <td>
                                                        @if(!empty($recipes[$i]->breakfastRecipe))
                                                            {{ $recipes[$i]->breakfastRecipe->name }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($recipes[$i]->lunchRecipe))
                                                            {{ $recipes[$i]->lunchRecipe->name }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($recipes[$i]->dinnerRecipe))
                                                            {{ $recipes[$i]->dinnerRecipe->name }}
                                                        @endif
                                                    </td>
                                                    <td<?php echo ($recipes[$i]->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?>></td>
                                                @else
                                                    <td colspan="4"></td>
                                                @endif
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
                                </td>
                                <td>{{ App\Libraries\Util::getMenuType($menu->type) }}</td>
                                <td>{{ App\Libraries\Util::getMenuStatus($menu->status) }}</td>
                            </tr>
                        @endforeach

                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    </form>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $menus])
            </div>
        </div>
    </div>

@stop