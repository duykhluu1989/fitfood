@extends('admin.layouts.main')

@section('title', 'New Widget')

@section('header', 'New Widget')

@section('content')

    <form method="post" action="{{ url('admin/widget/create') }}">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ url('admin/widget') }}" class="btn btn-primary btn-outline pull-right">Back</a>
                </div>
            </div>
        </div>

        @if(isset($errors))
            @include('admin.layouts.partials.form_error', ['errors' => $errors])
        @endif

        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Name</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" name="widget[name]" value="{{ $widget->name }}" autofocus="autofocus" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Type</h3>
                        </div>
                        <div class="panel-body">
                            <select class="form-control" name="widget[type]">
                                @foreach(App\Libraries\Util::getWidgetType() as $value => $label)
                                    @if($widget->type == $value)
                                        <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                    @else
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Status</h3>
                        </div>
                        <div class="panel-body">
                            <label class="checkbox-inline">
                                <input<?php echo ($widget->status ? ' checked="checked"' : ''); ?> type="checkbox" name="widget[status]" value="status" /><b>Active</b>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

    </form>

@stop