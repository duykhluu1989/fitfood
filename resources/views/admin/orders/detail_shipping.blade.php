@extends('admin.layouts.main')

@section('title', 'Detail Shipping')

@section('header', 'Detail Shipping - ' . $shipper->name . ' - ' . $date)

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-3">
                        <label class="form-control">Total Order: {{ count($orders) }}</label>
                    </div>
                    <div class="col-sm-3">
                        <?php
                        $totalBill = 0;
                        ?>
                        @foreach($orders as $order)
                            @if($order->payment_gateway == App\Libraries\Util::PAYMENT_GATEWAY_CASH_VALUE)
                                <?php
                                $totalPrice = $order->total_price;

                                if(count($order->transactions) > 0)
                                {
                                    foreach($order->transactions as $transaction)
                                    {
                                        if($transaction->type == App\Libraries\Util::TRANSACTION_TYPE_PAY_VALUE)
                                            $totalPrice -= $transaction->amount;
                                        else if($transaction->type == App\Libraries\Util::TRANSACTION_TYPE_BALANCE_PRICE_VALUE)
                                            $totalPrice += $transaction->amount;
                                        else if($transaction->type == App\Libraries\Util::TRANSACTION_TYPE_BALANCE_PAY_VALUE)
                                            $totalPrice -= $transaction->amount;
                                    }
                                }

                                if($totalPrice < 0)
                                    $totalPrice = 0;

                                $totalBill += $totalPrice;
                                ?>
                            @endif
                        @endforeach
                        <label class="form-control">Total Bill: {{ App\Libraries\Util::formatMoney($totalBill) }}</label>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('shipping/detail/export', ['id' => $shipper->id, 'date' => $date]) }}" data-toggle="tooltip" title="Export Excel" class="btn btn-primary btn-outline">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $times = App\Libraries\Util::getShippingTime();
                foreach($times as $key => $time)
                    $times[$key] = array();
                ?>
                @foreach($orders as $order)
                    @foreach($order->orderItems as $orderItem)
                        @foreach($orderItem->orderItemMeals as $orderItemMeal)
                            <?php
                            $times[$orderItemMeal->shipping_time][] = $order;
                            break;
                            ?>
                        @endforeach
                        <?php
                        break;
                        ?>
                    @endforeach
                @endforeach
                @foreach($times as $key => $timeOrders)
                    @if(count($timeOrders) > 0)
                        <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th class="info text-center">
                                @if($key == App\Libraries\Util::SHIPPING_TIME_NIGHT_BEFORE_VALUE)
                                    {{ App\Libraries\Util::SHIPPING_TIME_NIGHT_BEFORE_LABEL_ADMIN }}
                                @else
                                    {{ $key }}
                                @endif
                            </th>
                        </tr>
                        </tbody>
                        </table>
                        <?php
                        $i = 1;
                        ?>
                        @foreach($timeOrders as $order)
                            <?php
                            $rowClass = '';
                            if($i % 2 == 0)
                                $rowClass = ' class="active"';
                            ?>
                            <table class="table table-bordered">
                            <tbody>
                                <tr<?php echo $rowClass; ?>>
                                    <th>Order</th>
                                    <th>Order ID</th>
                                    <th>Bill</th>
                                    <th>Phone</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>District</th>
                                    <th>Priority</th>
                                </tr>
                                <tr<?php echo $rowClass; ?>>
                                    <td>
                                        <a href="{{ url('order/detail', ['id' => $order->id]) }}" class="btn btn-primary btn-outline">{{ $order->id }}</a>
                                    </td>
                                    <td>{{ $order->order_id }}</td>
                                    <td>
                                        @if($order->payment_gateway == App\Libraries\Util::PAYMENT_GATEWAY_CASH_VALUE)
                                            <?php
                                            $totalPrice = $order->total_price;

                                            if(count($order->transactions) > 0)
                                            {
                                                foreach($order->transactions as $transaction)
                                                {
                                                    if($transaction->type == App\Libraries\Util::TRANSACTION_TYPE_PAY_VALUE)
                                                        $totalPrice -= $transaction->amount;
                                                    else if($transaction->type == App\Libraries\Util::TRANSACTION_TYPE_BALANCE_PRICE_VALUE)
                                                        $totalPrice += $transaction->amount;
                                                    else if($transaction->type == App\Libraries\Util::TRANSACTION_TYPE_BALANCE_PAY_VALUE)
                                                        $totalPrice -= $transaction->amount;
                                                }
                                            }

                                            if($totalPrice < 0)
                                                $totalPrice = 0;

                                            echo App\Libraries\Util::formatMoney($totalPrice);
                                            ?>
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>{{ $order->customer->phone }}</td>
                                    <td>{{ $order->orderAddress->name }}</td>
                                    <td>{{ $order->orderAddress->address }}</td>
                                    <td>{{ $order->orderAddress->district }}</td>
                                    <td>{{ $order->shipping_priority }}</td>
                                </tr>
                                <?php
                                $meals = [
                                    App\Libraries\Util::MEAL_BREAKFAST_LABEL => 0,
                                    App\Libraries\Util::MEAL_LUNCH_LABEL => 0,
                                    App\Libraries\Util::MEAL_DINNER_LABEL => 0,
                                    App\Libraries\Util::MEAL_FRUIT_LABEL => 0,
                                    App\Libraries\Util::MEAL_VEGGIES_LABEL => 0,
                                    App\Libraries\Util::MEAL_BREAKFAST_LABEL . ' DOUBLE' => 0,
                                    App\Libraries\Util::MEAL_LUNCH_LABEL . ' DOUBLE' => 0,
                                    App\Libraries\Util::MEAL_DINNER_LABEL . ' DOUBLE' => 0,
                                    App\Libraries\Util::MEAL_FRUIT_LABEL . ' DOUBLE' => 0,
                                    App\Libraries\Util::MEAL_VEGGIES_LABEL . ' DOUBLE' => 0,
                                ];
                                $packs = array();
                                ?>
                                @foreach($order->orderItems as $orderItem)
                                    @foreach($orderItem->orderItemMeals as $orderItemMeal)
                                        <?php
                                        if(isset($packs[$orderItem->meal_pack]))
                                            $packs[$orderItem->meal_pack] += 1;
                                        else
                                            $packs[$orderItem->meal_pack] = 1;
                                        ?>
                                        @foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                                            <?php
                                            if($orderItemMealDetail->double)
                                                $mealName = $orderItemMealDetail->name . ' DOUBLE';
                                            else
                                                $mealName = $orderItemMealDetail->name;
                                            if(isset($meals[$mealName]))
                                                $meals[$mealName] += $orderItemMealDetail->quantity;
                                            else if($orderItemMealDetail->quantity)
                                                $meals[$mealName] = $orderItemMealDetail->quantity;
                                            ?>
                                        @endforeach
                                    @endforeach
                                @endforeach
                                @foreach($meals as $keyMeal => $quantity)
                                    <?php
                                    if($quantity == 0)
                                        unset($meals[$keyMeal]);
                                    ?>
                                @endforeach
                                <tr<?php echo $rowClass; ?>>
                                    <th colspan="5">Meals</th>
                                    <th colspan="3">Packs</th>
                                </tr>
                                <tr<?php echo $rowClass; ?>>
                                    <td colspan="5">
                                        <?php
                                        $j = 1;
                                        ?>
                                        @foreach($meals as $keyMeal => $quantity)
                                            <?php
                                            if($j == 1)
                                                echo $quantity . ' x ' . $keyMeal;
                                            else
                                                echo ' - ' . $quantity . ' x ' . $keyMeal;
                                            $j ++;
                                            ?>
                                        @endforeach
                                    </td>
                                    <td colspan="3">
                                        <?php
                                        $j = 1;
                                        ?>
                                        @foreach($packs as $keyPack => $quantity)
                                            <?php
                                            if($j == 1)
                                                echo $quantity . ' x ' . $keyPack;
                                            else
                                                echo ' - ' . $quantity . ' x ' . $keyPack;
                                            $j ++;
                                            ?>
                                        @endforeach
                                    </td>
                                </tr>
                            <?php
                            $i ++;
                            ?>
                            </tbody>
                            </table>
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    </div>

@stop