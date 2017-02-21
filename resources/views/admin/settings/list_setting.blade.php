@extends('admin.layouts.main')

@section('title', 'List Setting')

@section('header', 'List Setting')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $settings])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/setting/create') }}" data-toggle="tooltip" title="New Setting" class="btn btn-primary btn-outline">
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
                        <th>Type</th>
                        <th>Value</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/setting') }}" method="get">
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[name]" value="{{ (isset($filter['name']) ? $filter['name'] : '') }}" />
                            </td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[type]">
                                    <option value=""></option>
                                    @foreach(App\Libraries\Util::getSettingType() as $value => $label)
                                        @if(isset($filter['type']) && $filter['type'] !== '' && $filter['type'] == $value)
                                            <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td></td>
                        </tr>

                        <input type="submit" style="display: none" />
                    </form>
                    </thead>
                    <tbody>
                    @foreach($settings as $setting)
                        <tr>
                            <td>
                                <a href="{{ url('admin/setting/edit', ['id' => $setting->id]) }}" class="btn btn-primary btn-outline">{{ $setting->id }}</a>
                            </td>
                            <td>{{ $setting->name }}</td>
                            <td>{{ App\Libraries\Util::getSettingType($setting->type) }}</td>
                            <td><?php echo $setting->getSettingValueDetail(); ?></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $settings])
            </div>
        </div>
    </div>

@stop