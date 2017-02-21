@extends('admin.layouts.main')

@section('title', 'Edit Setting')

@section('header', 'Edit Setting - ' . $setting->name)

@section('content')

    <form method="post" action="{{ url('admin/setting/edit', ['id' => $setting->id]) }}">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ url('admin/setting') }}" class="btn btn-primary btn-outline pull-right">Back</a>
                </div>
            </div>
        </div>

        @if(isset($errors))
            @include('admin.layouts.partials.form_error', ['errors' => $errors])
        @endif

        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Name</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" value="{{ $setting->name }}" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Type</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" value="{{ App\Libraries\Util::getSettingType($setting->type) }}" readonly="readonly" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($setting->type == App\Libraries\Util::TYPE_SETTING_JSON_VALUE)

            @include('admin.settings.forms.json_setting', ['setting' => $setting])

        @elseif($setting->type == App\Libraries\Util::TYPE_SETTING_INT_VALUE)

            @include('admin.settings.forms.int_setting', ['setting' => $setting])

        @endif

        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

    </form>

@stop