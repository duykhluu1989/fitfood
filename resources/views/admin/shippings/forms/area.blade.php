<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($area->id) ? 'Create' : 'Update' }}</button>
            <a href="{{ url('admin/area') }}" class="btn btn-primary btn-outline pull-right">Back</a>
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
                    <input type="text" class="form-control" name="area[name]" value="{{ $area->name }}" autofocus="autofocus" required="required" />
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Price</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control InputMoney" name="area[shipping_price]" value="{{ App\Libraries\Util::formatMoney($area->shipping_price) }}" />
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
                        <input<?php echo ($area->status ? ' checked="checked"' : ''); ?> type="checkbox" name="area[status]" value="status" /><b>Active</b>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$shippingTimes = array();
if(!empty($area->shipping_time))
    $shippingTimes = json_decode($area->shipping_time, true);
?>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Time</h3>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    @foreach(App\Libraries\Util::getShippingTime() as $value => $label)
                        <td>
                            <label class="checkbox-inline">
                                @if(isset($shippingTimes[$value]))
                                    <input checked="checked" type="checkbox" name="area[shipping_time][{{ $value }}]" value="{{ $label }}" /><b>{{ $label }}</b>
                                @else
                                    <input type="checkbox" name="area[shipping_time][{{ $value }}]" value="{{ $label }}" /><b>{{ $label }}</b>
                                @endif
                            </label>
                        </td>
                    @endforeach
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

