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
                        <button id="ImportResourceButton" data-toggle="tooltip" title="Import Resource" class="btn btn-primary btn-outline">
                            <i class="fa fa-upload fa-fw"></i>
                        </button>
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

    <div id="ImportResourceModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Import Resource</h4>
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
                            <th>E</th>
                            <th>F</th>
                            <th>G</th>
                            <th>H</th>
                            <th>I</th>
                            <th>J</th>
                            <th>K</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>1</th>
                            <td>code</td>
                            <td>category</td>
                            <td>name</td>
                            <td>name_en</td>
                            <td>unit</td>
                            <td>quantity</td>
                            <td>price</td>
                            <td>calories</td>
                            <td>carb</td>
                            <td>fat</td>
                            <td>protein</td>
                        </tr>
                        <tr>
                            <th>2</th>
                            <td>BR</td>
                            <td>Meat</td>
                            <td>Ba Rọi</td>
                            <td>Bacon</td>
                            <td>gr</td>
                            <td>1000</td>
                            <td>50000</td>
                            <td>1000</td>
                            <td>1000</td>
                            <td>1000</td>
                            <td>1000</td>
                        </tr>
                        <tr>
                            <th>3</th>
                            <td>SD</td>
                            <td>Milk</td>
                            <td>Sữa Dê</td>
                            <td>Goat Milk</td>
                            <td>ml</td>
                            <td>1000</td>
                            <td>70000</td>
                            <td>10000</td>
                            <td>10000</td>
                            <td>10000</td>
                            <td>10000</td>
                        </tr>
                        </tbody>
                    </table>
                    <form method="post" action="{{ url('admin/resource/import') }}" enctype="multipart/form-data">
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

            $('#ImportResourceButton').click(function() {

                $('#ImportResourceModal').modal('show');

            });

            @if(session('importResource'))
            alert('{{ session('importResource') }}');
            @endif

        });

    </script>

@stop