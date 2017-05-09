@extends('admin.layouts.main')

@section('title', 'List Order')

@section('header', 'List Order')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-2">
                        @include('admin.layouts.partials.pagination', ['pagination' => $orders])
                    </div>
                    <div class="col-sm-1">
                        <label class="form-control">Total Pack: {{ $sumPack }}</label>
                    </div>
                    <div class="col-sm-2 form-inline">
                        <div class="form-group">
                            <label for="DatePicker">Week</label>
                            <input id="DatePicker" type="text" class="form-control" value="{{ $date }}" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{ url('admin/order/export?' . $queryString) }}" data-toggle="tooltip" title="Export Excel" class="btn btn-primary btn-outline">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Created Time</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th class="col-sm-1">Address</th>
                        <th>Shipping Time</th>
                        <th>Package</th>
                        <th>District</th>
                        <th>Gender</th>
                        <th>Payment Method</th>
                        <th>Email</th>
                        <th>Extra Request</th>
                        <th class="col-sm-1">Customer Note</th>
                        <th>Discount Code</th>
                        <th>Total Price</th>
                        <th colspan="3">Monday</th>
                        <th colspan="3">Tuesday</th>
                        <th colspan="3">Wednesday</th>
                        <th colspan="3">Thursday</th>
                        <th colspan="3">Friday</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/order') }}" method="get">
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="filter[order_id]" value="{{ (isset($filter['order_id']) ? $filter['order_id'] : '') }}" />
                            </td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[cancelled]">
                                    <option value=""></option>
                                    <option{{ ((isset($filter['cancelled']) && $filter['cancelled'] == 1) ? ' selected="selected"' : '') }} value="1">Cancelled</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="filter[name]" value="{{ (isset($filter['name']) ? $filter['name'] : '') }}" />
                            </td>
                            <td>
                                <input type="text" class="form-control" name="filter[phone]" value="{{ (isset($filter['phone']) ? $filter['phone'] : '') }}" />
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[email]" value="{{ (isset($filter['email']) ? $filter['email'] : '') }}" />
                            </td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[warning]">
                                    <option value=""></option>
                                    <option{{ ((isset($filter['warning']) && $filter['warning'] !== '' && $filter['warning'] == 1) ? ' selected="selected"' : '') }} value="1">Have</option>
                                    <option{{ ((isset($filter['warning']) && $filter['warning'] !== '' && $filter['warning'] == 0) ? ' selected="selected"' : '') }} value="0">None</option>
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <th>SA</th>
                            <th>TR</th>
                            <th>TO</th>
                            <th>SA</th>
                            <th>TR</th>
                            <th>TO</th>
                            <th>SA</th>
                            <th>TR</th>
                            <th>TO</th>
                            <th>SA</th>
                            <th>TR</th>
                            <th>TO</th>
                            <th>SA</th>
                            <th>TR</th>
                            <th>TO</th>
                        </tr>

                        <input type="hidden" name="date" value="{{ $date }}" />
                        <input type="submit" style="display: none" />
                    </form>
                    </thead>
                    <tbody>
                    <?php
                    $areasArr = App\Models\Area::getArrayActiveArea();
                    ?>
                    @foreach($orders as $order)
                        <?php
                        if(isset($duplicateOrderCustomerIds[$order->customer_id]))
                            $rowClass = 'class="warning"';
                        else if($order->warning)
                            $rowClass = 'class="danger"';
                        else
                            $rowClass = '';
                        $districtShippingPrice = $areasArr[$order->orderAddress->district]->shipping_price;
                        $extras = array();
                        foreach($order->orderExtras as $orderExtra)
                        {
                            if(empty($orderExtra->order_item_id))
                            {
                                if($orderExtra->code == App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_VALUE)
                                    $extras[] = App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL;
                                else if($orderExtra->code == App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_VALUE)
                                    $extras[] = App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL;
                                else
                                {
                                    $codes = explode(';', $orderExtra->code);

                                    foreach($codes as $code)
                                        $extras[] = App\Libraries\Util::getRequestChangeIngredient($code);
                                }
                            }
                        }
                        $extraRequest = '';
                        foreach($extras as $extra)
                        {
                            if($extraRequest == '')
                                $extraRequest = $extra;
                            else
                                $extraRequest .= ' - ' . $extra;
                        }
                        ?>
                        @foreach($order->orderItems as $orderItem)
                            <tr {{ $rowClass }}>
                                <td><a href="{{ url('/admin/order/detail', ['id' => $order->id]) }}" class="btn btn-primary btn-outline">{{ $order->id }}</a></td>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ $order->orderAddress->name }}</td>
                                <td>{{ $order->customer->phone }}</td>
                                <td>{{ $order->orderAddress->address }}</td>
                                <td>{{ App\Libraries\Util::getShippingTime($order->shipping_time) }}</td>
                                <td>{{ $orderItem->meal_pack }}</td>
                                <td>{{ $order->orderAddress->district . (!empty($districtShippingPrice) ? (' (' . App\Libraries\Util::formatMoney($districtShippingPrice) . ')') : '') }}</td>
                                <td>{{ App\Libraries\Util::getGender($order->orderAddress->gender) }}</td>
                                <td>{{ App\Libraries\Util::getPaymentMethod($order->payment_gateway) }}</td>
                                <td>{{ $order->orderAddress->email }}</td>
                                <td>
                                    <?php
                                    $oiExtras = array();
                                    foreach($orderItem->orderExtras as $orderExtra)
                                    {
                                        if($orderExtra->code == App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_VALUE)
                                            $oiExtras[] = App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL;
                                        else if($orderExtra->code == App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_VALUE)
                                            $oiExtras[] = App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL;
                                        else
                                        {
                                            $codes = explode(';', $orderExtra->code);

                                            foreach($codes as $code)
                                                $oiExtras[] = App\Libraries\Util::getRequestChangeIngredient($code);
                                        }
                                    }
                                    $oiExtraRequest = $extraRequest;
                                    foreach($oiExtras as $oiExtra)
                                    {
                                        if($oiExtraRequest == '')
                                            $oiExtraRequest = $oiExtra;
                                        else
                                            $oiExtraRequest .= ' - ' . $oiExtra;
                                    }
                                    ?>
                                    {{ $oiExtraRequest }}
                                </td>
                                <td>{{ $order->customer_note }}</td>
                                <td>{{ !empty($order->orderDiscount) ? $order->orderDiscount->code : '' }}</td>
                                <td>{{ App\Libraries\Util::formatMoney($order->total_price) }}</td>
                                @if($orderItem->main_dish && $orderItem->price > 0)
                                    <?php
                                    $lastDayOfWeek = 0;
                                    ?>
                                    @foreach($orderItem->orderItemMeals as $orderItemMeal)
                                        <?php
                                        if($orderItemMeal->day_of_week != $lastDayOfWeek + 1)
                                        {
                                            for($loop = $lastDayOfWeek;$loop < $orderItemMeal->day_of_week - 1;$loop ++)
                                                echo '<td colspan="3"></td>';
                                        }
                                        $meals = [
                                            App\Libraries\Util::MEAL_BREAKFAST_LABEL => [],
                                            App\Libraries\Util::MEAL_LUNCH_LABEL => [],
                                            App\Libraries\Util::MEAL_DINNER_LABEL => [],
                                        ];
                                        foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                                        {
                                            if($orderItemMealDetail->quantity > 0)
                                            {
                                                if($orderItemMealDetail->double)
                                                {
                                                    if(isset($meals[$orderItemMealDetail->name]['M']))
                                                        $meals[$orderItemMealDetail->name]['M'] += $orderItemMealDetail->quantity;
                                                    else
                                                        $meals[$orderItemMealDetail->name]['M'] = $orderItemMealDetail->quantity;
                                                }
                                                else
                                                {
                                                    if(isset($meals[$orderItemMealDetail->name]['F']))
                                                        $meals[$orderItemMealDetail->name]['F'] += $orderItemMealDetail->quantity;
                                                    else
                                                        $meals[$orderItemMealDetail->name]['F'] = $orderItemMealDetail->quantity;
                                                }
                                            }
                                        }
                                        foreach($meals as $detailMealOfDay)
                                        {
                                            echo '<td class="info">';
                                            if(count($detailMealOfDay) > 0)
                                            {
                                                $mealOfDayDetail = '';

                                                foreach($detailMealOfDay as $detailType => $detailQuantity)
                                                {
                                                    if($mealOfDayDetail == '')
                                                        $mealOfDayDetail .= $detailQuantity . ' ' . $detailType;
                                                    else
                                                        $mealOfDayDetail .= ' - ' . $detailQuantity . ' ' . $detailType;
                                                }

                                                echo $mealOfDayDetail;
                                            }
                                            echo '</td>';
                                        }
                                        $lastDayOfWeek = $orderItemMeal->day_of_week;
                                        ?>
                                    @endforeach
                                    @if($lastDayOfWeek < 5)
                                        <?php
                                        for($loop = $lastDayOfWeek;$loop < 5;$loop ++)
                                            echo '<td colspan="3"></td>';
                                        ?>
                                    @endif
                                @else
                                    <td colspan="15"></td>
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $orders])
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

                window.location.href = '{{ url('admin/order') }}?date=' + $(this).val();

            });

        });

    </script>

@stop