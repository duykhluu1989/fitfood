@extends('admin.layouts.main')

@section('title', 'Edit Widget')

@section('header', 'Edit Widget - ' . $widget->name)

@section('content')

    <form method="post" action="{{ url('widget/edit', ['id' => $widget->id]) }}" enctype="multipart/form-data">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ url('widget') }}" class="btn btn-primary btn-outline pull-right">Back</a>
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
                            <input type="text" class="form-control" value="{{ $widget->name }}" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Type</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" value="{{ App\Libraries\Util::getWidgetType($widget->type) }}" readonly="readonly" />
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

        @if($widget->type == App\Libraries\Util::TYPE_WIDGET_SLIDER_VALUE)

            @include('admin.blogs.forms.slider_widget', ['widget' => $widget])

        @endif

        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

    </form>

@stop