@extends('admin.layouts.main')

@section('title', 'List Shipping')

@section('header', 'List Shipping - ' . $date)

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6 form-inline">
                        <div class="form-group">
                            <label for="DatePicker">Date</label>
                            <input id="DatePicker" type="text" class="form-control" value="{{ $date }}" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        @if(count($orders) > 0)
                            @if($finishFulfillment === null)
                                <label>
                                    Still have order no assign shipper
                                </label>
                            @elseif($finishFulfillment === false)
                                <button id="FinishShippingButton" data-toggle="tooltip" title="Finish Shipping" class="btn btn-primary btn-outline">
                                    <i class="fa fa-truck fa-fw"></i>
                                </button>
                            @else
                                <label>
                                    Finished shipping
                                </label>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                    <?php
                    $meals = [
                        App\Libraries\Util::MEAL_BREAKFAST_LABEL => [],
                        App\Libraries\Util::MEAL_LUNCH_LABEL => [],
                        App\Libraries\Util::MEAL_DINNER_LABEL => [],
                        App\Libraries\Util::MEAL_FRUIT_LABEL => [],
                        App\Libraries\Util::MEAL_VEGGIES_LABEL => [],
                        App\Libraries\Util::MEAL_BREAKFAST_LABEL . ' DOUBLE' => [],
                        App\Libraries\Util::MEAL_LUNCH_LABEL . ' DOUBLE' => [],
                        App\Libraries\Util::MEAL_DINNER_LABEL . ' DOUBLE' => [],
                        App\Libraries\Util::MEAL_FRUIT_LABEL . ' DOUBLE' => [],
                        App\Libraries\Util::MEAL_VEGGIES_LABEL . ' DOUBLE' => [],
                    ];
                    $packs = array();
                    $totalOrders = array();
                    $shippers = array()
                    ?>
                    @foreach($orders as $order)
                        <?php
                        $countCurrentOrder = false;
                        ?>
                        @foreach($order->orderItems as $orderItem)
                            @foreach($orderItem->orderItemMeals as $orderItemMeal)
                                <?php
                                if(!empty($orderItemMeal->shipper))
                                {
                                    if(!isset($shippers[$orderItemMeal->shipper->id]))
                                        $shippers[$orderItemMeal->shipper->id] = $orderItemMeal->shipper->name;
                                    if(isset($packs[$orderItem->meal_pack][$orderItemMeal->shipper->id]))
                                        $packs[$orderItem->meal_pack][$orderItemMeal->shipper->id] += 1;
                                    else
                                        $packs[$orderItem->meal_pack][$orderItemMeal->shipper->id] = 1;
                                    if($countCurrentOrder == false)
                                    {
                                        if(isset($totalOrders[$orderItemMeal->shipper->id]))
                                            $totalOrders[$orderItemMeal->shipper->id] += 1;
                                        else
                                            $totalOrders[$orderItemMeal->shipper->id] = 1;
                                        $countCurrentOrder = true;
                                    }
                                }
                                else
                                {
                                    if(!isset($shippers[0]))
                                        $shippers[0] = 'NO ASSIGN';
                                    if(isset($packs[$orderItem->meal_pack][0]))
                                        $packs[$orderItem->meal_pack][0] += 1;
                                    else
                                        $packs[$orderItem->meal_pack][0] = 1;
                                    if($countCurrentOrder == false)
                                    {
                                        if(isset($totalOrders[0]))
                                            $totalOrders[0] += 1;
                                        else
                                            $totalOrders[0] = 1;
                                        $countCurrentOrder = true;
                                    }
                                }
                                ?>
                                @foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                                    <?php
                                    if($orderItemMealDetail->double)
                                        $mealName = $orderItemMealDetail->name . ' DOUBLE';
                                    else
                                        $mealName = $orderItemMealDetail->name;
                                    if(!empty($orderItemMeal->shipper))
                                    {
                                        if(isset($meals[$mealName][$orderItemMeal->shipper->id]))
                                            $meals[$mealName][$orderItemMeal->shipper->id] += $orderItemMealDetail->quantity;
                                        else if($orderItemMealDetail->quantity)
                                            $meals[$mealName][$orderItemMeal->shipper->id] = $orderItemMealDetail->quantity;
                                    }
                                    else
                                    {
                                        if(isset($meals[$mealName][0]))
                                            $meals[$mealName][0] += $orderItemMealDetail->quantity;
                                        else if($orderItemMealDetail->quantity)
                                            $meals[$mealName][0] = $orderItemMealDetail->quantity;
                                    }
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
                    $countShippers = count($shippers);
                    $countPacks = count($packs);
                    ?>
                    @if($countShippers > 0)
                        @for($i = 0;$i <= $countShippers;$i ++)
                            @if($i == 0)
                                <tr>
                                    <th>Shipper</th>
                                    <th>Order</th>
                                    @for($j = 1;$j <= $countMeals;$j ++)
                                        <?php
                                        if($j == 1)
                                            reset($meals);
                                        else
                                            next($meals);
                                        $key = key($meals);
                                        ?>
                                        <th>{{ $key }}</th>
                                    @endfor
                                    <th style="vertical-align: middle" rowspan="{{ $countShippers + 1 }}">
                                        P
                                        <br />
                                        a
                                        <br />
                                        c
                                        <br />
                                        k
                                        <br />
                                        s
                                    </th>
                                    @for($j = 1;$j <= $countPacks;$j ++)
                                        <?php
                                        if($j == 1)
                                            reset($packs);
                                        else
                                            next($packs);
                                        $key = key($packs);
                                        ?>
                                        <th>{{ $key }}</th>
                                    @endfor
                                </tr>
                            @else
                                <?php
                                if($i == 1)
                                    reset($shippers);
                                else
                                    next($shippers);
                                $shipperId = key($shippers);
                                ?>
                                <tr>
                                    <td>
                                        @if($shipperId != 0)
                                            <a href="{{ url('shipping/detail', ['id' => $shipperId, 'date' => $date]) }}" class="btn btn-primary btn-outline">
                                                {{ $shippers[$shipperId] }}
                                            </a>
                                        @else
                                            {{ $shippers[$shipperId] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($totalOrders[$shipperId]))
                                            {{ $totalOrders[$shipperId] }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    @for($j = 1;$j <= $countMeals;$j ++)
                                        <?php
                                        if($j == 1)
                                            reset($meals);
                                        else
                                            next($meals);
                                        $key = key($meals);
                                        ?>
                                        <td>
                                            @if(isset($meals[$key][$shipperId]))
                                                {{ $meals[$key][$shipperId] }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                    @endfor
                                    @for($j = 1;$j <= $countPacks;$j ++)
                                        <?php
                                        if($j == 1)
                                            reset($packs);
                                        else
                                            next($packs);
                                        $key = key($packs);
                                        ?>
                                        <td>
                                            @if(isset($packs[$key][$shipperId]))
                                                {{ $packs[$key][$shipperId] }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endif
                        @endfor
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.layouts.partials.loading')

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

                window.location.href = '{{ url('shipping') }}?date=' + $(this).val();

            });

            @if($finishFulfillment === false)
                $('#FinishShippingButton').click(function() {

                    showLoadingScreen();

                    $.ajax({

                        url: '{{ url('shipping/finish', ['date' => $date]) }}',
                        type: 'post',
                        data: '_token={{ csrf_token() }}',
                        success: function(result) {

                            if(result)
                            {
                                $('#FinishShippingButton').parent().html('<label>Finished shipping</label>');
                                closeLoadingScreen();
                            }

                        }

                    });

                });
            @endif

        });

    </script>

@stop