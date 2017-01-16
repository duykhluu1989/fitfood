<?php
$settingValue = array();
if(!empty($setting->value))
    $settingValue = json_decode($setting->value, true);

switch($setting->name)
{
    case App\Libraries\Util::SETTING_NAME_OFF_TIME:
?>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Start</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="DatePicker form-control" name="setting[value][start_time]" value="{{ isset($settingValue['start_time']) ? $settingValue['start_time'] : '' }}" readonly="readonly" required="required" />
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">End</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="DatePicker form-control" name="setting[value][end_time]" value="{{ isset($settingValue['end_time']) ? $settingValue['end_time'] : '' }}" readonly="readonly" required="required" />
                </div>
            </div>
        </div>
    </div>
</div>

<?php
        break;
}
?>

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('.DatePicker').datepicker({

                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                showOtherMonths: true,
                selectOtherMonths: true

            });

        });

    </script>

@stop