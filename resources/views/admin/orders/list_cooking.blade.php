@extends('admin.layouts.main')

@section('title', 'List Cooking')

@section('header', 'List Cooking')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-4 form-inline">
                        <div class="form-group">
                            <label for="DatePicker">Week</label>
                            <input id="DatePicker" type="text" class="form-control" value="{{ $date }}" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <a href="{{ url('admin/cooking/export?date=' . $date) }}" data-toggle="tooltip" title="Export Excel" class="btn btn-primary btn-outline">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Sunday<br />{{ date('Y-m-d', strtotime($startWeek) - App\Libraries\Util::TIMESTAMP_ONE_DAY) }}</th>
                        <th>Monday<br />{{ $startWeek }}</th>
                        <th>Tuesday<br />{{ date('Y-m-d', strtotime($startWeek) + App\Libraries\Util::TIMESTAMP_ONE_DAY) }}</th>
                        <th>Wednesday<br />{{ date('Y-m-d', strtotime($startWeek) + (App\Libraries\Util::TIMESTAMP_ONE_DAY * 2)) }}</th>
                        <th>Thursday<br />{{ date('Y-m-d', strtotime($startWeek) + (App\Libraries\Util::TIMESTAMP_ONE_DAY * 3)) }}</th>
                        <th>Friday<br />{{ date('Y-m-d', strtotime($startWeek) + (App\Libraries\Util::TIMESTAMP_ONE_DAY * 4)) }}</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $meals = [
                        App\Libraries\Util::MEAL_BREAKFAST_LABEL => [],
                        App\Libraries\Util::MEAL_LUNCH_LABEL => [],
                        App\Libraries\Util::MEAL_DINNER_LABEL => [],
                        App\Libraries\Util::MEAL_FRUIT_LABEL => [],
                        App\Libraries\Util::MEAL_VEGGIES_LABEL => [],
                    ];
                    $packs = array();
                    ?>
                    @foreach($orders as $order)
                        @foreach($order->orderItems as $orderItem)
                            @foreach($orderItem->orderItemMeals as $orderItemMeal)
                                <?php
                                if($orderItemMeal->meal_date != $orderItemMeal->cook_date)
                                    $dateOfWeek = $orderItemMeal->day_of_week - 1;
                                else
                                    $dateOfWeek = $orderItemMeal->day_of_week;
                                if(isset($packs[$orderItem->meal_pack][$dateOfWeek]))
                                    $packs[$orderItem->meal_pack][$dateOfWeek] += 1;
                                else
                                    $packs[$orderItem->meal_pack][$dateOfWeek] = 1;
                                ?>
                                @foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                                    <?php
                                    if($orderItemMealDetail->double)
                                        $quantity = $orderItemMealDetail->quantity * 2;
                                    else
                                        $quantity = $orderItemMealDetail->quantity;
                                    if(isset($meals[$orderItemMealDetail->name][$dateOfWeek]))
                                        $meals[$orderItemMealDetail->name][$dateOfWeek] += $quantity;
                                    else
                                        $meals[$orderItemMealDetail->name][$dateOfWeek] = $quantity;
                                    ?>
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                    @foreach($meals as $keyMeal => $dayMeal)
                        <?php
                        if(count($dayMeal) == 0)
                            unset($meals[$keyMeal]);
                        ?>
                    @endforeach
                    <?php
                    $countMeals = count($meals);
                    ?>
                    @for($i = 1;$i <= $countMeals;$i ++)
                        <tr>
                            @if($i == 1)
                                <?php
                                reset($meals);
                                ?>
                            @else
                                <?php
                                next($meals);
                                ?>
                            @endif
                            <?php
                            $key = key($meals);
                            ?>
                            <th>{{ $key }}</th>
                            <?php
                            $total = 0;
                            ?>
                            @for($j = 0;$j <= 5;$j ++)
                                <td>
                                    @if(isset($meals[$key][$j]))
                                        <?php
                                        echo $meals[$key][$j];
                                        $total += $meals[$key][$j];
                                        ?>
                                    @else
                                        0
                                    @endif
                                </td>
                            @endfor
                            <td>{{ $total }}</td>
                        </tr>
                    @endfor
                    <tr>
                        <th class="text-center" colspan="7">Packs</th>
                    </tr>
                    <?php
                    $countPacks = count($packs);
                    ?>
                    @for($i = 1;$i <= $countPacks;$i ++)
                        <tr>
                            @if($i == 1)
                                <?php
                                reset($packs);
                                ?>
                            @else
                                <?php
                                next($packs);
                                ?>
                            @endif
                            <?php
                            $key = key($packs);
                            ?>
                            <th>{{ $key }}</th>
                            @for($j = 0;$j <= 5;$j ++)
                                <td>
                                    @if(isset($packs[$key][$j]))
                                        {{ $packs[$key][$j] }}
                                    @else
                                        0
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('#DatePicker').datepicker({

                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                showOtherMonths: true,
                selectOtherMonths: true

            });

            $('#DatePicker').change(function() {

                window.location.href = '{{ url('admin/cooking') }}?date=' + $(this).val();

            });

        });

    </script>

@stop