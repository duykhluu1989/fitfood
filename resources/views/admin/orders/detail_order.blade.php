@extends('admin.layouts.main')

@section('title', 'Detail Order')

@section('header', 'Detail Order - ' . $order->order_id . (!empty($order->fromOrder) ? (' - Re Order From - ' . $order->fromOrder->order_id) : ''))

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">
                @if((empty($order->cancelled_at) || $order->fulfillment_status != App\Libraries\Util::FULFILLMENT_STATUS_PENDING_VALUE) && $order->financial_status == App\Libraries\Util::FINANCIAL_STATUS_PENDING_VALUE)
                    <button id="ConfirmPaymentButton" data-toggle="tooltip" title="Confirm Payment" class="btn btn-primary btn-outline">
                        <i class="fa fa-money fa-fw"></i>
                    </button>
                @endif
                @if(empty($order->cancelled_at) && strtotime($order->start_week) - (App\Libraries\Util::TIMESTAMP_ONE_DAY * 5) > strtotime(date('Y-m-d')))
                    <a href="{{ url('admin/order/move/currentWeek', ['id' => $order->id]) }}" onclick="return showConfirmMessage();" data-toggle="tooltip" title="Move To Current Week" class="btn btn-primary btn-outline">
                        <i class="fa fa-reply fa-fw"></i>
                    </a>
                @endif
                @if(empty($order->cancelled_at))
                    <button id="RemoveOrderWarningButton" data-toggle="tooltip" title="Remove Warning" class="btn btn-primary btn-outline{{ $order->warning ? '' : ' hidden' }}">
                        <i class="fa fa-check fa-fw"></i>
                    </button>
                    <button id="SetOrderWarningButton" data-toggle="tooltip" title="Set Warning" class="btn btn-primary btn-outline{{ $order->warning ? ' hidden' : '' }}">
                        <i class="fa fa-warning fa-fw"></i>
                    </button>
                @endif
                @if(empty($order->cancelled_at))
                    <a href="{{ url('admin/order/address/edit', ['id' => $order->id]) }}" data-toggle="tooltip" title="Edit Address" class="btn btn-primary btn-outline">
                        <i class="fa fa-edit fa-fw"></i>
                    </a>
                @endif
                    <a href="{{ url('admin/order/reorder', ['id' => $order->id]) }}" data-toggle="tooltip" title="Re Order" class="btn btn-primary btn-outline">
                       <i class="fa fa-copy fa-fw"></i>
                    </a>
                @if(empty($order->cancelled_at) && $order->fulfillment_status != App\Libraries\Util::FULFILLMENT_STATUS_FULFILLED_VALUE)
                    <button id="AddOrderExtraRequestButton" data-toggle="tooltip" title="Add Extra Request" class="btn btn-primary btn-outline">
                        <i class="fa fa-asterisk fa-fw"></i>
                    </button>

                    <button id="CancelOrderButton" data-toggle="tooltip" title="Cancel Order" class="btn btn-primary btn-outline pull-right">
                        <i class="fa fa-trash-o fa-fw"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Price</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Pack</th>
                        <th>Cancelled</th>
                        <th>Cancel Reason</th>
                        <th>Money</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->orderItems as $orderItem)
                        <tr>
                            <td>{{ $orderItem->meal_pack . (!empty($orderItem->meal_pack_description) ? ' (' . $orderItem->meal_pack_description . ')' : '') }}</td>
                            <td>{{ $orderItem->cancelled_at }}</td>
                            <td>{{ $orderItem->cancel_reason }}</td>
                            <td id="OrderItemPrice_{{ $orderItem->id }}">{{ App\Libraries\Util::formatMoney($orderItem->price) }}</td>
                        </tr>
                    @endforeach
                    @if(count($order->orderExtras) > 0)
                        <tr>
                            <th colspan="3">Request</th>
                            <th></th>
                        </tr>
                    @endif
                    @foreach($order->orderExtras as $orderExtra)
                        <tr>
                            <td colspan="3">
                                <?php
                                if($orderExtra->code == App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_VALUE)
                                    echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL;
                                else if($orderExtra->code == App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_VALUE)
                                    echo App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL;
                                else
                                    echo App\Libraries\Util::getRequestChangeIngredient($orderExtra->code);
                                ?>
                            </td>
                            <td id="OrderExtraPrice_{{ $orderExtra->id }}">{{ App\Libraries\Util::formatMoney($orderExtra->price) }}</td>
                        </tr>
                    @endforeach
                    @if($order->shipping_price)
                        <tr>
                            <th colspan="3">Shipping Price</th>
                            <td id="TotalShipping">{{ App\Libraries\Util::formatMoney($order->shipping_price) }}</td>
                        </tr>
                    @endif
                    @if($order->orderDiscount)
                        <tr>
                            <th colspan="3">Discount Code: <a href="{{ url('admin/discount/edit', ['id' => $order->orderDiscount->discount->id]) }}" target="_blank">{{ $order->orderDiscount->code }}</a></th>
                            <td id="TotalDiscount">{{ App\Libraries\Util::formatMoney(-$order->total_discounts) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th colspan="3">Total Price</th>
                        <td id="TotalPrice">{{ App\Libraries\Util::formatMoney($order->total_price) }}</td>
                    </tr>
                    <?php
                    $paidAmount = 0;
                    $balancePriceAmount = 0;
                    $refundedAmount = 0;
                    $needRefundAmount = 0;

                    if(count($order->transactions) > 0)
                    {
                        foreach($order->transactions as $transaction)
                        {
                            if($transaction->type == App\Libraries\Util::TRANSACTION_TYPE_PAY_VALUE)
                                $paidAmount += $transaction->amount;
                            else if($transaction->type == App\Libraries\Util::TRANSACTION_TYPE_REFUND_VALUE)
                                $refundedAmount += $transaction->amount;
                            else if($transaction->type == App\Libraries\Util::TRANSACTION_TYPE_BALANCE_PRICE_VALUE)
                                $balancePriceAmount += $transaction->amount;
                            else if($transaction->type == App\Libraries\Util::TRANSACTION_TYPE_BALANCE_PAY_VALUE)
                                $paidAmount += $transaction->amount;
                        }

                        if($paidAmount > ($balancePriceAmount + $order->total_price))
                        {
                            $needRefundAmount = $paidAmount - ($balancePriceAmount + $order->total_price + $refundedAmount);
                            if($needRefundAmount < 0)
                                $needRefundAmount = 0;
                        }
                    }

                    ?>
                    @if($balancePriceAmount > 0)
                        <tr>
                            <th colspan="3">Balance Price To Re Order</th>
                            <td>{{ App\Libraries\Util::formatMoney($balancePriceAmount) }}</td>
                        </tr>
                    @endif
                    @if($paidAmount > 0)
                        <tr>
                            <th colspan="3">Paid</th>
                            <td>{{ App\Libraries\Util::formatMoney($paidAmount) }}</td>
                        </tr>
                    @endif
                    @if($needRefundAmount > 0)
                        <tr>
                            <th colspan="3">Need Refund</th>
                            <td>{{ App\Libraries\Util::formatMoney($needRefundAmount) }}</td>
                        </tr>
                    @endif
                    @if($refundedAmount > 0)
                        <tr>
                            <th colspan="3">Refunded</th>
                            <td>{{ App\Libraries\Util::formatMoney($refundedAmount) }}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Meal</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Pack</th>
                        <th></th>
                        <th>Monday<br />{{ $order->start_week }}</th>
                        <th>Tuesday<br />{{ date('Y-m-d', strtotime($order->start_week) + App\Libraries\Util::TIMESTAMP_ONE_DAY) }}</th>
                        <th>Wednesday<br />{{ date('Y-m-d', strtotime($order->start_week) + (App\Libraries\Util::TIMESTAMP_ONE_DAY * 2)) }}</th>
                        <th>Thursday<br />{{ date('Y-m-d', strtotime($order->start_week) + (App\Libraries\Util::TIMESTAMP_ONE_DAY * 3)) }}</th>
                        <th>Friday<br />{{ date('Y-m-d', strtotime($order->start_week) + (App\Libraries\Util::TIMESTAMP_ONE_DAY * 4)) }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $defaultMeals = [
                        App\Libraries\Util::MEAL_BREAKFAST_LABEL,
                        App\Libraries\Util::MEAL_LUNCH_LABEL,
                        App\Libraries\Util::MEAL_DINNER_LABEL,
                        App\Libraries\Util::MEAL_FRUIT_LABEL,
                        App\Libraries\Util::MEAL_VEGGIES_LABEL,
                        App\Libraries\Util::MEAL_JUICE_LABEL,
                    ];
                    $mainPackIds = array();
                    $sidePackIds = array();
                    ?>
                    @foreach($order->orderItems as $orderItem)
                        @foreach($orderItem->orderItemMeals as $orderItemMeal)
                            @if($orderItemMeal->status == App\Libraries\Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE)
                                @foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                                    <?php
                                    if(!in_array($orderItem->id, $mainPackIds) && ($orderItemMealDetail->name != App\Libraries\Util::MEAL_FRUIT_LABEL && $orderItemMealDetail->name != App\Libraries\Util::MEAL_VEGGIES_LABEL && $orderItemMealDetail->name != App\Libraries\Util::MEAL_JUICE_LABEL))
                                    {
                                        $mainPackIds[] = $orderItem->id;
                                        break;
                                    }
                                    ?>
                                @endforeach
                                <?php
                                if(!in_array($orderItem->id, $mainPackIds))
                                    $sidePackIds[] = $orderItem->id;
                                break;
                                ?>
                            @endif
                        @endforeach
                    @endforeach
                    @foreach($order->orderItems as $orderItem)
                        @if($orderItem->type == App\Libraries\Util::MEAL_PACK_TYPE_PACK_VALUE)
                            <?php
                            $meals = [
                                App\Libraries\Util::MEAL_BREAKFAST_LABEL => [],
                                App\Libraries\Util::MEAL_LUNCH_LABEL => [],
                                App\Libraries\Util::MEAL_DINNER_LABEL => [],
                            ];
                            $dateDetails = array();
                            ?>
                            @foreach($orderItem->orderItemMeals as $orderItemMeal)
                                <?php
                                $dateDetails[$orderItemMeal->day_of_week] = $orderItemMeal;
                                ?>
                                @foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                                    <?php
                                    $meals[$orderItemMealDetail->name][$orderItemMeal->day_of_week][] = $orderItemMealDetail;
                                    ?>
                                @endforeach
                            @endforeach
                            <?php
                            if(count($meals[App\Libraries\Util::MEAL_BREAKFAST_LABEL]) == 0 && count($meals[App\Libraries\Util::MEAL_LUNCH_LABEL]) == 0 && count($meals[App\Libraries\Util::MEAL_DINNER_LABEL]) == 0)
                            {
                                unset($meals[App\Libraries\Util::MEAL_BREAKFAST_LABEL]);
                                unset($meals[App\Libraries\Util::MEAL_LUNCH_LABEL]);
                                unset($meals[App\Libraries\Util::MEAL_DINNER_LABEL]);
                            }

                            $countMeals = count($meals);
                            ?>
                            @if($countMeals == 0)
                                <tr>
                                    <td>{{ $orderItem->meal_pack }}<br />{{ $orderItem->meal_pack_description }}</td>
                                    @for($j = 1;$j <= 6;$j ++)
                                        <td></td>
                                    @endfor
                                </tr>
                            @else
                                @for($i = 1;$i <= $countMeals;$i ++)
                                    <tr>
                                        @if($i == 1)
                                            <td rowspan="{{ $countMeals + 4 }}">
                                                <span id="OrderItemPackName_{{ $orderItem->id }}">{{ $orderItem->meal_pack }}</span>
                                                <br />
                                                {{ $orderItem->meal_pack_description }}
                                                <br />
                                                <br />
                                                @if(empty($order->cancelled_at) && empty($orderItem->cancelled_at) && $order->fulfillment_status != App\Libraries\Util::FULFILLMENT_STATUS_FULFILLED_VALUE)
                                                    <button id="ChangeOrderItemButton_{{ $orderItem->id }}" data-toggle="tooltip" title="Change Pack" class="btn btn-primary btn-outline ChangeOrderItemButton">
                                                        <i class="fa fa-exchange fa-fw"></i>
                                                    </button>
                                                @endif
                                                @if(empty($order->cancelled_at) && empty($orderItem->cancelled_at) && $order->fulfillment_status != App\Libraries\Util::FULFILLMENT_STATUS_FULFILLED_VALUE
                                                    && in_array($orderItem->id, $mainPackIds))
                                                    <button id="AddCustomOrderItemMealDetailButton_{{ $orderItem->id }}" data-toggle="tooltip" title="Add Custom Meal" class="btn btn-primary btn-outline AddCustomOrderItemMealDetailButton">
                                                        <i class="fa fa-plus fa-fw"></i>
                                                    </button>
                                                @endif
                                                @if(empty($order->cancelled_at) && empty($orderItem->cancelled_at) && $order->fulfillment_status != App\Libraries\Util::FULFILLMENT_STATUS_FULFILLED_VALUE
                                                    && (in_array($orderItem->id, $sidePackIds) || count($mainPackIds) > 1))
                                                    <button id="CancelOrderItemButton_{{ $orderItem->id }}" data-toggle="tooltip" title="Cancel Pack" class="btn btn-primary btn-outline pull-right CancelOrderItemButton">
                                                        <i class="fa fa-trash-o fa-fw"></i>
                                                    </button>
                                                @endif
                                            </td>
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
                                        @for($j = 1;$j <= 5;$j ++)
                                            @if(isset($dateDetails[$j]))
                                                @if($dateDetails[$j]->status == App\Libraries\Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE && $key != App\Libraries\Util::MEAL_FRUIT_LABEL && $key != App\Libraries\Util::MEAL_VEGGIES_LABEL)
                                                    <td class="droppable OrderItemMeal_{{ $dateDetails[$j]->id }}" id="MealCourse_{{ $dateDetails[$j]->id }}_{{ (in_array($key, $defaultMeals) ? $key : rawurlencode($key)) }}">
                                                        @if(isset($meals[$key][$j]))
                                                            @foreach($meals[$key][$j] as $mealDetail)
                                                                @if($mealDetail->quantity)
                                                                    @if($mealDetail->double)
                                                                        <div id="MealCourseDetail_{{ $mealDetail->id }}" class="btn btn-primary btn-circle btn-lg draggable">
                                                                            <i class="fa fa-cutlery fa-fw"></i>
                                                                        </div>
                                                                    @else
                                                                        <div id="MealCourseDetail_{{ $mealDetail->id }}" class="btn btn-primary btn-circle draggable">
                                                                            <i class="fa fa-cutlery fa-fw"></i>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                @else
                                                    <td class="OrderItemMeal_{{ $dateDetails[$j]->id }}">
                                                        @if(isset($meals[$key][$j]))
                                                            @foreach($meals[$key][$j] as $mealDetail)
                                                                @if($mealDetail->quantity)
                                                                    @if($mealDetail->double)
                                                                        <div class="btn btn-primary btn-outline btn-circle btn-lg">
                                                                            <i class="fa fa-cutlery fa-fw"></i>
                                                                        </div>
                                                                    @else
                                                                        <div class="btn btn-primary btn-outline btn-circle">
                                                                            <i class="fa fa-cutlery fa-fw"></i>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                @endif
                                            @else
                                                <td></td>
                                            @endif
                                        @endfor
                                    </tr>
                                @endfor
                                <tr>
                                    <th>Shipping Time</th>
                                    @for($j = 1;$j <= 5;$j ++)
                                        @if(isset($dateDetails[$j]))
                                            @if($dateDetails[$j]->status == App\Libraries\Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE)
                                                <td class="OrderItemMeal_{{ $dateDetails[$j]->id }}">
                                                    <select class="form-control OrderItemShippingTime OrderItemShippingTimeDate_{{ $j }}">
                                                        @foreach(App\Models\Area::getShippingTimeByDistrict($order->orderAddress->district) as $value => $label)
                                                            @if($value == $dateDetails[$j]->shipping_time)
                                                                <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                                            @else
                                                                <option value="{{ $value }}">{{ $label }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                            @else
                                                <td>
                                                    {{ App\Libraries\Util::getShippingTime($dateDetails[$j]->shipping_time) }}
                                                </td>
                                            @endif
                                        @else
                                            <td></td>
                                        @endif
                                    @endfor
                                </tr>
                                <tr>
                                    <th>Shipper</th>
                                    @for($j = 1;$j <= 5;$j ++)
                                        @if(isset($dateDetails[$j]) && !empty($dateDetails[$j]->shipper))
                                            @if($dateDetails[$j]->status == App\Libraries\Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE)
                                                <td class="OrderItemMeal_{{ $dateDetails[$j]->id }}">
                                                    {{ $dateDetails[$j]->shipper->name }}
                                                </td>
                                            @else
                                                <td>
                                                    {{ $dateDetails[$j]->shipper->name }}
                                                </td>
                                            @endif
                                        @else
                                            <td></td>
                                        @endif
                                    @endfor
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    @for($j = 1;$j <= 5;$j ++)
                                        @if(isset($dateDetails[$j]))
                                            @if($dateDetails[$j]->status == App\Libraries\Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE)
                                                <td class="OrderItemMeal_{{ $dateDetails[$j]->id }}">
                                                    {{ $dateDetails[$j]->status }}
                                                </td>
                                            @else
                                                <td>
                                                    {{ $dateDetails[$j]->status }}
                                                </td>
                                            @endif
                                        @else
                                            <td></td>
                                        @endif
                                    @endfor
                                </tr>
                                <tr>
                                    <th></th>
                                    <?php
                                    $countPendingDates = 0;
                                    if(count($dateDetails) > 0)
                                    {
                                        foreach($dateDetails as $tempDD)
                                        {
                                            if($tempDD->status == App\Libraries\Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE)
                                                $countPendingDates += 1;
                                        }
                                    }
                                    ?>
                                    @for($j = 1;$j <= 5;$j ++)
                                        @if(isset($dateDetails[$j]) && $countPendingDates > 1 && $dateDetails[$j]->status == App\Libraries\Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE)
                                            <td class="OrderItemMeal_{{ $dateDetails[$j]->id }}">
                                                <button class="btn btn-primary btn-outline DeleteMealDay OrderItemDeleteMealDay_{{ $orderItem->id }}" id="DeleteMealDay_{{ $dateDetails[$j]->id }}" data-toggle="tooltip" title="Delete Meal Day">
                                                    <i class="fa fa-trash-o fa-fw"></i>
                                                </button>
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                    @endfor
                                </tr>
                            @endif
                        @else
                            @if(empty($order->cancelled_at) && empty($orderItem->cancelled_at))
                                <tr>
                                    <td rowspan="3">
                                        <span id="OrderItemPackName_{{ $orderItem->id }}">{{ $orderItem->meal_pack }}</span>
                                        <br />
                                        {{ $orderItem->meal_pack_description }}
                                        <br />
                                        <br />
                                        @if($order->fulfillment_status != App\Libraries\Util::FULFILLMENT_STATUS_FULFILLED_VALUE && $orderItem->orderItemProduct->status == App\Libraries\Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE)
                                            <button id="ChangeOrderItemButton_{{ $orderItem->id }}" data-toggle="tooltip" title="Change Pack" class="btn btn-primary btn-outline ChangeOrderItemButton">
                                                <i class="fa fa-exchange fa-fw"></i>
                                            </button>
                                            <button id="CancelOrderItemButton_{{ $orderItem->id }}" data-toggle="tooltip" title="Cancel Pack" class="btn btn-primary btn-outline pull-right CancelOrderItemButton">
                                                <i class="fa fa-trash-o fa-fw"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <th>Shipping Time</th>
                                    <td colspan="5">
                                        {{ App\Libraries\Util::getShippingTime($orderItem->orderItemProduct->shipping_time) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Shipper</th>
                                    <td colspan="5">
                                        @if(!empty($orderItem->orderItemProduct->shipper))
                                            {{ $orderItem->orderItemProduct->shipper->name }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td colspan="5">
                                        {{ $orderItem->orderItemProduct->status }}
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $orderItem->meal_pack }}<br />{{ $orderItem->meal_pack_description }}</td>
                                    @for($j = 1;$j <= 6;$j ++)
                                        <td></td>
                                    @endfor
                                </tr>
                            @endif
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">General</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Financial</th>
                        <th>Fulfillment</th>
                        <th>Payment</th>
                        <th>Shipping Time</th>
                        <th>Created</th>
                        <th>Cancelled</th>
                        <th>Cancel Reason</th>
                        <th>Start Week</th>
                        <th>End Week</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $order->financial_status }}</td>
                        <td>{{ $order->fulfillment_status }}</td>
                        <td>{{ App\Libraries\Util::getPaymentMethod($order->payment_gateway) }}</td>
                        <td>{{ App\Libraries\Util::getShippingTime($order->shipping_time) }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->cancelled_at }}</td>
                        <td>{{ $order->cancel_reason }}</td>
                        <td>{{ $order->start_week }}</td>
                        <td>{{ $order->end_week }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="panel-title">Note</h3>
                    </div>
                    <div class="col-sm-6">
                        <button data-toggle="tooltip" title="Edit Note" class="btn btn-primary btn-outline" id="EditNoteButton">
                            <i class="fa fa-edit fa-fw"></i>
                        </button>
                        <button data-toggle="tooltip" title="Save Note" class="btn btn-primary btn-outline" id="SaveNoteButton" style="display: none">
                            <i class="fa fa-save fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <textarea class="form-control" readonly="readonly" id="OrderNoteTextArea">{{ $order->customer_note }}</textarea>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Customer</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>District</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $order->customer->customer_id }}</td>
                        <td>{{ $order->orderAddress->name }}</td>
                        <td>{{ $order->customer->phone }}</td>
                        <td>{{ $order->orderAddress->address }}</td>
                        <td>{{ $order->orderAddress->district }}</td>
                        <td>{{ $order->orderAddress->email }}</td>
                    </tr>
                    <tr>
                        <th colspan="3">LatLong</th>
                        <th colspan="3">Address Google</th>
                    </tr>
                    <tr>
                        <td colspan="3">{{ $order->orderAddress->latitude . ' - ' . $order->orderAddress->longitude }}</td>
                        <td colspan="3">{{ $order->orderAddress->address_google }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(count($order->transactions) > 0)
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Financial</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Action</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Created</th>
                            <th>Shipper</th>
                            <th>Note</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->type }}</td>
                                <td>{{ $transaction->gateway }}</td>
                                <td>{{ App\Libraries\Util::formatMoney($transaction->amount) }}</td>
                                <td>{{ $transaction->created_at }}</td>
                                <td>{{ !empty($transaction->shipper_id) ? $transaction->shipper->name : '' }}</td>
                                <td>{{ $transaction->note }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if((empty($order->cancelled_at) || $order->fulfillment_status != App\Libraries\Util::FULFILLMENT_STATUS_PENDING_VALUE) && $order->financial_status == App\Libraries\Util::FINANCIAL_STATUS_PENDING_VALUE)
        <div id="ConfirmPaymentModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirm Payment</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ url('admin/order/transaction/pay', ['id' => $order->id]) }}">
                            <div class="form-group">
                                <label>Method</label>
                                <select name="method" id="ConfirmPaymentMethodDropDown" class="form-control">
                                    @foreach(App\Libraries\Util::getPaymentMethod() as $value => $label)
                                        @if($order->payment_gateway == $value)
                                            <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="text" id="ConfirmPaymentAmountInput" name="amount" value="{{ App\Libraries\Util::formatMoney($balancePriceAmount + $order->total_price - $paidAmount) }}" class="form-control InputMoney" />
                            </div>
                            <div class="form-group">
                                <label>Shipper</label>
                                <select name="shipper" id="ConfirmPaymentShipperDropDown" class="form-control"<?php echo ($order->payment_gateway != App\Libraries\Util::PAYMENT_GATEWAY_CASH_VALUE ? ' disabled="disabled"' : ' required="required"'); ?>>
                                    <option value=""></option>
                                    <?php
                                    $shipperDropDown = array();
                                    ?>
                                    @foreach($order->orderItems as $orderItem)
                                        @foreach($orderItem->orderItemMeals as $orderItemMeal)
                                            @if(!empty($orderItemMeal->shipper_id) && !isset($shipperDropDown[$orderItemMeal->shipper_id]))
                                                <?php
                                                $shipperDropDown[$orderItemMeal->shipper_id] = $orderItemMeal->shipper->name;
                                                ?>
                                            @endif
                                        @endforeach
                                    @endforeach
                                    @if(count($shipperDropDown) == 0)
                                        <?php
                                        $shipperDropDown = App\Models\Shipper::getDropDownActiveShipper();
                                        ?>
                                    @endif
                                    @foreach($shipperDropDown as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="DateTimePicker">Date</label>
                                <input id="DateTimePicker" type="text" name="date" class="form-control" value="{{ date('Y-m-d H:i') }}" />
                            </div>
                            <div class="form-group">
                                <label>Note</label>
                                <input type="text" name="note" class="form-control" />
                            </div>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(empty($order->cancelled_at) && $order->fulfillment_status != App\Libraries\Util::FULFILLMENT_STATUS_FULFILLED_VALUE)
        <div id="CancelOrderModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Cancel Order</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ url('admin/order/cancel', ['id' => $order->id]) }}">
                            <div class="form-group">
                                <label>Cancel Reason</label>
                                <input type="text" name="cancel_reason" class="form-control" />
                            </div>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="CancelOrderItemModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="CancelOrderItemTitle"></h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group">
                                <label>Cancel Reason</label>
                                <input type="text" name="cancel_reason" class="form-control" />
                            </div>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="AddCustomOrderItemMealDetailModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="AddCustomOrderItemMealDetailTitle"></h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group">
                                <label>Meal</label>
                                <input type="text" id="AddCustomOrderItemMealDetailInput" class="form-control" required="required" />
                                <input type="hidden" id="AddCustomOrderItemMealDetailHidden" name="recipe_name" />
                            </div>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="ChangeOrderItemModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="ChangeOrderItemTitle"></h4>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group">
                                <label>To Pack</label>
                                <select class="form-control" name="pack" required="required">
                                    <option value=""></option>
                                    @foreach(App\Models\MealPack::getModelActiveMealPack() as $mealPackModel)
                                        <option value="{{ $mealPackModel->id }}">{{ $mealPackModel->name . (!empty($mealPackModel->description) ? '(' . $mealPackModel->description . ')' : '') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="AddOrderExtraRequestModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add Extra Request</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ url('admin/order/extra/add', ['id' => $order->id]) }}">
                            <div class="form-group">
                                <label>Request</label>
                                <select class="form-control" name="request" required="required">
                                    <option value=""></option>
                                    @foreach(App\Libraries\Util::getRequestChangeIngredient() as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                    <option value="{{ App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_VALUE }}">{{ App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL }}</option>
                                    <option value="{{ App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_VALUE }}">{{ App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL }}</option>
                                </select>
                            </div>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="submit" value="Save" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('admin.layouts.partials.loading')

@stop

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('#DateTimePicker').datetimepicker({

                format: 'Y-m-d H:i'

            });

            $('.draggable').draggable({

                helper: 'clone',
                revert: 'invalid'

            });

            $('.droppable').droppable({

                drop: function(event, ui) {

                    var elem = $(this);
                    var fromId = ui.draggable.parent().prop('id');
                    var toId = elem.prop('id');

                    var fromIdArr = fromId.split('_');
                    var toIdArr = toId.split('_');

                    var targetIdArr = ui.draggable.context.id.split('_');

                    if(fromIdArr[1] != toIdArr[1] || fromIdArr[2] == toIdArr[2])
                        return false;

                    showLoadingScreen();

                    $.ajax({

                        url: '{{ url('admin/order/itemMeal/change') }}',
                        type: 'post',
                        data: '_token={{ csrf_token() }}&to=' + toIdArr[2] + '&target=' + targetIdArr[1],
                        success: function(result) {

                            if(result)
                            {
                                elem.append(ui.draggable.context);
                                closeLoadingScreen();
                            }

                        }

                    });

                }

            });

            $('.DeleteMealDay').click(function() {

                if(!showConfirmMessage())
                    return false;

                var parentElem = $(this).parent();
                var meal = $(this).prop('id');
                var mealArr = meal.split('_');

                showLoadingScreen();

                $.ajax({

                    url: '{{ url('admin/order/itemMeal/delete') }}',
                    type: 'post',
                    data: '_token={{ csrf_token() }}&meal=' + mealArr[1],
                    success: function(result) {

                        if(result)
                        {
                            result = JSON.parse(result);

                            if(result.delete)
                            {
                                if(result.delete.orderItemMeal)
                                {
                                    result.delete.orderItemMeal.forEach(function(item, index) {

                                        $('.OrderItemMeal_' + item).each(function() {

                                            $(this).empty();

                                        });

                                    });
                                }
                            }

                            if(result.update)
                            {
                                if(result.update.orderItem)
                                {
                                    for(var index in result.update.orderItem)
                                    {
                                        $('#OrderItemPrice_' + index).html(formatMoney(result.update.orderItem[index].price.toString()));

                                        if($('.OrderItemDeleteMealDay_' + index).length == 1)
                                            $('.OrderItemDeleteMealDay_' + index).parent().empty();
                                    }
                                }

                                if(result.update.orderExtra)
                                {
                                    for(var index in result.update.orderExtra)
                                        $('#OrderExtraPrice_' + index).html(formatMoney(result.update.orderExtra[index].price.toString()));
                                }

                                if(result.update.order)
                                {
                                    if(result.update.order.total_price)
                                    {
                                        $('#TotalPrice').html(formatMoney(result.update.order.total_price.toString()));

                                        $('#ConfirmPaymentAmountInput').val(formatMoney(result.update.order.total_price.toString()));
                                    }

                                    if(result.update.order.shipping_price)
                                        $('#TotalShipping').html(formatMoney(result.update.order.shipping_price.toString()));

                                    if(result.update.order.total_discounts)
                                        $('#TotalDiscount').html(formatMoney(result.update.order.total_discounts.toString()));
                                }
                            }

                            closeLoadingScreen();
                        }

                    }

                });

            });

            $('.OrderItemShippingTime').change(function() {

                if(!showConfirmMessage())
                    return false;

                var shippingTime = $(this).val();
                var shippingClass = $(this).prop('class');
                var shippingClassArr = shippingClass.split('OrderItemShippingTimeDate_');

                showLoadingScreen();

                $.ajax({

                    url: '{{ url('admin/order/itemMeal/edit/shippingTime') }}',
                    type: 'post',
                    data: '_token={{ csrf_token() }}&order=<?php echo $order->id ?>&date=' + shippingClassArr[1] + '&shipping=' + shippingTime,
                    success: function(result) {

                        if(result)
                        {
                            $('.OrderItemShippingTimeDate_' + shippingClassArr[1]).each(function() {

                                $(this).val(shippingTime);

                            });

                            closeLoadingScreen();
                        }

                    }

                });

            });

            $('#EditNoteButton').click(function() {

                $(this).hide();
                $('#SaveNoteButton').show();
                $('#OrderNoteTextArea').removeAttr('readonly');

            });

            $('#SaveNoteButton').click(function() {

                $(this).hide();
                $('#EditNoteButton').show();

                var note = $('#OrderNoteTextArea');
                var noteText = note.val().trim();

                showLoadingScreen();

                $.ajax({

                    url: '{{ url('admin/order/note/edit') }}',
                    type: 'post',
                    data: '_token={{ csrf_token() }}&order=<?php echo $order->id ?>&note=' + noteText,
                    success: function(result) {

                        if(result)
                        {
                            note.prop('readonly', 'readonly');

                            closeLoadingScreen();
                        }

                    }

                });

            });

            @if((empty($order->cancelled_at) || $order->fulfillment_status != App\Libraries\Util::FULFILLMENT_STATUS_PENDING_VALUE) && $order->financial_status == App\Libraries\Util::FINANCIAL_STATUS_PENDING_VALUE)
                $('#ConfirmPaymentButton').click(function() {

                    $('#ConfirmPaymentModal').modal('show');

                });

                $('#ConfirmPaymentMethodDropDown').change(function() {

                    if($(this).val() != '{{ App\Libraries\Util::PAYMENT_GATEWAY_CASH_VALUE }}')
                        $('#ConfirmPaymentShipperDropDown').val('').prop('disabled', 'disabled').removeAttr('required');
                    else
                        $('#ConfirmPaymentShipperDropDown').prop('required', 'required').removeAttr('disabled');

                });
            @endif

            @if(empty($order->cancelled_at) && $order->fulfillment_status != App\Libraries\Util::FULFILLMENT_STATUS_FULFILLED_VALUE)
                $('#CancelOrderButton').click(function() {

                    $('#CancelOrderModal').modal('show');

                });

                $('.CancelOrderItemButton').click(function() {

                    var idArr = $(this).prop('id').split('_');

                    $('#CancelOrderItemTitle').html('Cancel Pack - ' + $('#OrderItemPackName_' + idArr[1]).html());
                    $('#CancelOrderItemModal').find('form').prop('action', '<?php echo url('admin/order/cancelItem'); ?>/' + idArr[1]);
                    $('#CancelOrderItemModal').modal('show');

                });

                $('.AddCustomOrderItemMealDetailButton').click(function() {

                    var idArr = $(this).prop('id').split('_');

                    $('#AddCustomOrderItemMealDetailTitle').html('Add Custom Meal For Pack - ' + $('#OrderItemPackName_' + idArr[1]).html());
                    $('#AddCustomOrderItemMealDetailModal').find('form').prop('action', '<?php echo url('admin/order/itemMeal/add/customMeal'); ?>/' + idArr[1]);
                    $('#AddCustomOrderItemMealDetailModal').modal('show');

                });

                $('#AddCustomOrderItemMealDetailInput').autocomplete({

                    minLength: 3,
                    source: function(request, response) {

                        $.ajax({
                            url: '{{ url('admin/order/get/autoComplete/recipe') }}',
                            type: 'post',
                            data: '_token={{ csrf_token() }}&term=' + request.term,
                            success: function(result) {

                                if(result)
                                {
                                    result = JSON.parse(result);
                                    response(result);
                                }

                            }
                        });

                    },
                    select: function(event, ui) {

                        $(this).val(ui.item.name);
                        $('#AddCustomOrderItemMealDetailHidden').val(ui.item.name);

                        return false;
                    }

                }).autocomplete('instance')._renderItem = function(ul, item) {

                    return $('<li>').append('<a>' + item.name + (item.name_en ? (' - ' + item.name_en) : '') + '</a>').appendTo(ul);

                };

                $('#AddCustomOrderItemMealDetailModal form').submit(function() {

                    if($('#AddCustomOrderItemMealDetailHidden').val() == '')
                    {
                        alert('Please choose meal from list recipe');
                        return false;
                    }

                });

                $('.ChangeOrderItemButton').click(function() {

                    var idArr = $(this).prop('id').split('_');

                    $('#ChangeOrderItemTitle').html('Change Pack - ' + $('#OrderItemPackName_' + idArr[1]).html());
                    $('#ChangeOrderItemModal').find('form').prop('action', '<?php echo url('admin/order/itemMeal/change'); ?>/' + idArr[1]);
                    $('#ChangeOrderItemModal').modal('show');

                });

                $('#AddOrderExtraRequestButton').click(function() {

                    $('#AddOrderExtraRequestModal').modal('show');

                });
            @endif

            @if(empty($order->cancelled_at))
                $('#RemoveOrderWarningButton').click(function() {

                    showLoadingScreen();

                    $.ajax({

                        url: '{{ url('admin/order/remove/warning', ['id' => $order->id]) }}',
                        type: 'post',
                        data: '_token={{ csrf_token() }}',
                        success: function(result) {

                            if(result)
                            {
                                $('#RemoveOrderWarningButton').addClass('hidden');
                                $('#SetOrderWarningButton').removeClass('hidden');

                                closeLoadingScreen();
                            }

                        }

                    });

                });

                $('#SetOrderWarningButton').click(function() {

                    showLoadingScreen();

                    $.ajax({

                        url: '{{ url('admin/order/set/warning', ['id' => $order->id]) }}',
                        type: 'post',
                        data: '_token={{ csrf_token() }}',
                        success: function(result) {

                            if(result)
                            {
                                $('#SetOrderWarningButton').addClass('hidden');
                                $('#RemoveOrderWarningButton').removeClass('hidden');

                                closeLoadingScreen();
                            }

                        }

                    });

                });
            @endif

            @if(session('orderError'))
                alert("{{ session()->pull('orderError') }}");
            @endif

        });

    </script>

@stop