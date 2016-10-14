<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($mealPack->id) ? 'Create' : 'Update' }}</button>
            <a href="{{ url('admin/mealPack') }}" class="btn btn-primary btn-outline pull-right">Back</a>
        </div>
    </div>
</div>

@if(isset($errors))
    @include('admin.layouts.partials.form_error', ['errors' => $errors])
@endif

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Name</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="mealPack[name]" value="{{ $mealPack->name }}" autofocus="autofocus" required="required" />
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Name EN</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="mealPack[name_en]" value="{{ $mealPack->name_en }}" />
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Price</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control InputMoney" name="mealPack[price]" value="{{ App\Libraries\Util::formatMoney($mealPack->price) }}" required="required" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Description</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="mealPack[description]" value="{{ $mealPack->description }}" />
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Mini Description</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="mealPack[mini_description]" value="{{ $mealPack->mini_description }}" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Description EN</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="mealPack[description_en]" value="{{ $mealPack->description_en }}" />
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Mini Description EN</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="mealPack[mini_description_en]" value="{{ $mealPack->mini_description_en }}" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Type</h3>
                </div>
                <div class="panel-body">
                    <select class="form-control" id="PackageTypeDropDown" name="mealPack[type]">
                        @foreach(App\Libraries\Util::getMealPackType() as $value => $label)
                            @if($value == $mealPack->type)
                                <option selected="selected" value="<?php echo $value; ?>">{{ $label }}</option>
                            @else
                                <option value="<?php echo $value; ?>">{{ $label }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Status</h3>
                </div>
                <div class="panel-body">
                    <select class="form-control" name="mealPack[status]">
                        @foreach(App\Libraries\Util::getStatus() as $value => $label)
                            @if($value == $mealPack->status)
                                <option selected="selected" value="<?php echo $value; ?>">{{ $label }}</option>
                            @else
                                <option value="<?php echo $value; ?>">{{ $label }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$doubles = array();
if(!empty($mealPack->double))
    $doubles = json_decode($mealPack->double, true);
?>

<div class="col-sm-12" id="PackageTypeOptionDiv"<?php echo ($mealPack->type == App\Libraries\Util::MEAL_PACK_TYPE_PACK_VALUE) ? '' : ' style="display:none"'; ?>>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Option</h3>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>
                        <label class="checkbox-inline">
                            <input<?php echo ($mealPack->breakfast ? ' checked="checked"' : ''); ?> type="checkbox" id="BreakfastCheck" name="mealPack[breakfast]" value="breakfast" /><b>Breakfast</b>
                        </label>
                    </td>
                    <td>
                        <label class="checkbox-inline">
                            <input<?php echo ($mealPack->lunch ? ' checked="checked"' : ''); ?> type="checkbox" id="LunchCheck" name="mealPack[lunch]" value="lunch" /><b>Lunch</b>
                        </label>
                    </td>
                    <td>
                        <label class="checkbox-inline">
                            <input<?php echo ($mealPack->dinner ? ' checked="checked"' : ''); ?> type="checkbox" id="DinnerCheck" name="mealPack[dinner]" value="dinner" /><b>Dinner</b>
                        </label>
                    </td>
                    <td>
                        <label class="checkbox-inline">
                            <input<?php echo ($mealPack->fruit ? ' checked="checked"' : ''); ?> type="checkbox" name="mealPack[fruit]" value="dinner" /><b>Fruit</b>
                        </label>
                    </td>
                    <td>
                        <label class="checkbox-inline">
                            <input<?php echo ($mealPack->veggies ? ' checked="checked"' : ''); ?> type="checkbox" name="mealPack[veggies]" value="dinner" /><b>Veggies</b>
                        </label>
                    </td>
                    <td>
                        <label class="checkbox-inline">
                            <input<?php echo ($mealPack->juice ? ' checked="checked"' : ''); ?> type="checkbox" name="mealPack[juice]" value="juice" /><b>Juice</b>
                        </label>
                    </td>
                    <td>
                        <label class="checkbox-inline">
                            <input<?php echo ($mealPack->vegetarian ? ' checked="checked"' : ''); ?> type="checkbox" name="mealPack[vegetarian]" value="vegetarian" /><b>Vegetarian</b>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="checkbox-inline">
                            <input<?php echo (isset($doubles['breakfast']) ? ' checked="checked"' : ''); ?> type="checkbox" id="BreakfastDoubleCheck" name="mealPack[breakfast_double]" value="breakfast_double"<?php echo ($mealPack->breakfast ? '' : ' disabled="disabled"'); ?> /><b>Breakfast Double</b>
                        </label>
                    </td>
                    <td>
                        <label class="checkbox-inline">
                            <input<?php echo (isset($doubles['lunch']) ? ' checked="checked"' : ''); ?> type="checkbox" id="LunchDoubleCheck" name="mealPack[lunch_double]" value="lunch_double"<?php echo ($mealPack->lunch ? '' : ' disabled="disabled"'); ?> /><b>Lunch Double</b>
                        </label>
                    </td>
                    <td>
                        <label class="checkbox-inline">
                            <input<?php echo (isset($doubles['dinner']) ? ' checked="checked"' : ''); ?> type="checkbox" id="DinnerDoubleCheck" name="mealPack[dinner_double]" value="dinner_double"<?php echo ($mealPack->dinner ? '' : ' disabled="disabled"'); ?> /><b>Dinner Double</b>
                        </label>
                    </td>
                    <td colspan="4"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Image (1250 x 1003)</h3>
        </div>
        <div class="panel-body">
            <input type="file" class="form-control" name="image" accept=".jpg, .jpeg, .png, .gif, .JPG, .JPEG, .PNG, .GIF" />
            @if(!empty($mealPack->image_src))
                <img src="{{ $mealPack->image_src }}" width="50%" alt="Fitfood" />
            @endif
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('#BreakfastCheck').click(function() {

                if($(this).prop('checked'))
                    $('#BreakfastDoubleCheck').removeAttr('disabled');
                else
                    $('#BreakfastDoubleCheck').prop('disabled', 'disabled').removeAttr('checked');

            });

            $('#LunchCheck').click(function() {

                if($(this).prop('checked'))
                    $('#LunchDoubleCheck').removeAttr('disabled');
                else
                    $('#LunchDoubleCheck').prop('disabled', 'disabled').removeAttr('checked');

            });

            $('#DinnerCheck').click(function() {

                if($(this).prop('checked'))
                    $('#DinnerDoubleCheck').removeAttr('disabled');
                else
                    $('#DinnerDoubleCheck').prop('disabled', 'disabled').removeAttr('checked');

            });

            $('#PackageTypeDropDown').change(function() {

                if($(this).val() == '<?php echo App\Libraries\Util::MEAL_PACK_TYPE_PACK_VALUE ?>')
                    $('#PackageTypeOptionDiv').show();
                else
                    $('#PackageTypeOptionDiv').hide();

            });

        });

    </script>

@stop

