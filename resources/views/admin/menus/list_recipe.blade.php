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
                        <button id="ImportRecipeButton" data-toggle="tooltip" title="Import Recipe" class="btn btn-primary btn-outline">
                            <i class="fa fa-upload fa-fw"></i>
                        </button>
                        <button value="delete" data-toggle="tooltip" title="Delete" class="btn btn-primary btn-outline ControlButtonControlForm" disabled="disabled">
                            <i class="fa fa-trash-o fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            @if($recipes->total() > 0)
                                <input class="CheckboxAllControlForm" type="checkbox" />
                            @endif
                        </th>
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
                    <form id="ControlForm" action="{{ url('admin/recipe/control') }}" method="post">
                        @foreach($recipes as $recipe)
                            <?php
                            $countResource = count($recipe->recipeResources);
                            ?>
                            @for($i = 0;$i < $countResource;$i ++)
                                @if($i == 0)
                                    <tr>
                                        <td rowspan="{{ $countResource }}">
                                            <input class="CheckboxControlForm" name="id[]" type="checkbox" value="{{ $recipe->id }}" />
                                        </td>
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

                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    </form>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $recipes])
            </div>
        </div>
    </div>

    <div id="ImportRecipeModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Import Recipe</h4>
                </div>
                <div class="modal-body">
                    <label>Template</label>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>A</th>
                            <th>B</th>
                            <th>C</th>
                            <th>D</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>1</th>
                            <td>name</td>
                            <td>name_en</td>
                            <td>resource_code</td>
                            <td>resource_quantity</td>
                        </tr>
                        <tr>
                            <th>2</th>
                            <td>Trứng Hấp Chả Cua</td>
                            <td>Steamed Egg Crab Rolls</td>
                            <td>EGG</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <th>3</th>
                            <td></td>
                            <td></td>
                            <td>ONI</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <th>4</th>
                            <td></td>
                            <td></td>
                            <td>CRAB</td>
                            <td>300</td>
                        </tr>
                        <tr>
                            <th>5</th>
                            <td>Xà Lát Cá Hồi</td>
                            <td>Salmon Salad</td>
                            <td>SALD</td>
                            <td>500</td>
                        </tr>
                        <tr>
                            <th>6</th>
                            <td></td>
                            <td></td>
                            <td>EGG</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <th>7</th>
                            <td></td>
                            <td></td>
                            <td>ONI</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <th>8</th>
                            <td></td>
                            <td></td>
                            <td>SALM</td>
                            <td>300</td>
                        </tr>
                        </tbody>
                    </table>
                    <form method="post" action="{{ url('admin/recipe/import') }}" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>File</label>
                            <input type="file" class="form-control" name="excel" accept=".xls, .xlsx, .csv, .XLS, .XLSX, .CSV" required="required" />
                        </div>
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="submit" value="Import" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('#ImportRecipeButton').click(function() {

                $('#ImportRecipeModal').modal('show');

            });

            @if(session('importRecipe'))
            alert('{{ session('importRecipe') }}');
            @endif

        });

    </script>

@stop