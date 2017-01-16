@extends('admin.layouts.main')

@section('title', 'New Setting')

@section('header', 'New Setting')

@section('content')

    <form method="post" action="{{ url('admin/setting/create') }}">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="submit" class="btn btn-primary">Create</button>
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
                            <input type="text" class="form-control" name="setting[name]" value="{{ $setting->name }}" autofocus="autofocus" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Type</h3>
                        </div>
                        <div class="panel-body">
                            <select class="form-control" name="setting[type]">
                                @foreach(App\Libraries\Util::getSettingType() as $value => $label)
                                    @if($setting->type == $value)
                                        <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                    @else
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

    </form>

@stop