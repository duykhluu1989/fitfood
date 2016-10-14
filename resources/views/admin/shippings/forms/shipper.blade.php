<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($shipper->id) ? 'Create' : 'Update' }}</button>
            <a href="{{ url('admin/shipper') }}" class="btn btn-primary btn-outline pull-right">Back</a>
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
                    <input type="text" class="form-control" name="shipper[name]" value="{{ $shipper->name }}" autofocus="autofocus" required="required" />
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Phone</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="shipper[phone]" value="{{ $shipper->phone }}" required="required" />
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Status</h3>
                </div>
                <div class="panel-body">
                    <label class="checkbox-inline">
                        <input<?php echo ($shipper->status ? ' checked="checked"' : ''); ?> type="checkbox" name="shipper[status]" value="status" /><b>Active</b>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

