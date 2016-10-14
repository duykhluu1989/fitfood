@extends('admin.layouts.main')

@section('title', 'List Order')

@section('header', 'List Order')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-4">
                        @include('admin.layouts.partials.pagination', ['pagination' => $orders])
                    </div>
                    <div class="col-sm-2">
                        <label class="form-control">Total Pack: {{ $sumPack }}</label>
                    </div>
                    <div class="col-sm-3 form-inline">
                        <div class="form-group">
                            <label for="DatePicker">Week</label>
                            <input id="DatePicker" type="text" class="form-control" value="{{ $date }}" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <a href="{{ url('admin/order/export?' . $queryString) }}" data-toggle="tooltip" title="Export Excel" class="btn btn-primary btn-outline">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th>Order ID</th>
                        <th>Phone</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Warning</th>
                        <th>Status</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/order') }}" method="get">
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="filter[order_id]" value="{{ (isset($filter['order_id']) ? $filter['order_id'] : '') }}" />
                            </td>
                            <td>
                                <input type="text" class="form-control" name="filter[phone]" value="{{ (isset($filter['phone']) ? $filter['phone'] : '') }}" />
                            </td>
                            <td>
                                <input type="text" class="form-control" name="filter[name]" value="{{ (isset($filter['name']) ? $filter['name'] : '') }}" />
                            </td>
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
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[cancelled]">
                                    <option value=""></option>
                                    <option{{ ((isset($filter['cancelled']) && $filter['cancelled'] == 1) ? ' selected="selected"' : '') }} value="1">Cancelled</option>
                                </select>
                            </td>
                        </tr>

                        <input type="hidden" name="date" value="{{ $date }}" />
                        <input type="submit" style="display: none" />
                    </form>
                    </tbody>
                </table>
                <?php
                $i = 1;
                ?>
                @foreach($orders as $order)
                    <?php
                    $rowClass = '';
                    if(isset($duplicateOrderCustomerIds[$order->customer_id]))
                        $rowClass = ' class="warning"';
                    else if($order->warning)
                        $rowClass = ' class="danger"';
                    else if($i % 2 == 0)
                        $rowClass = ' class="active"';
                    ?>
                    <table class="table table-bordered">
                        <tbody>
                        <tr<?php echo $rowClass; ?>>
                            <th>ID</th>
                            <th>Order ID</th>
                            <th>Financial</th>
                            <th>Fulfillment</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Shipping Time</th>
                            <th>Created</th>
                            <th>Cancelled</th>
                        </tr>
                        <tr<?php echo $rowClass; ?>>
                            <td>
                                <a href="{{ url('admin/order/detail', ['id' => $order->id]) }}" class="btn btn-primary btn-outline">{{ $order->id }}</a>
                            </td>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->financial_status }}</td>
                            <td>{{ $order->fulfillment_status }}</td>
                            <td>{{ App\Libraries\Util::formatMoney($order->total_price) }}</td>
                            <td>{{ App\Libraries\Util::getPaymentMethod($order->payment_gateway) }}</td>
                            <td>{{ App\Libraries\Util::getShippingTime($order->shipping_time) }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->cancelled_at }}</td>
                        </tr>
                        <tr<?php echo $rowClass; ?>>
                            <td rowspan="<?php echo (count($order->orderExtras) > 0 ? '4' : '3'); ?>">
                                @if(!empty($order->customer_note))
                                    <i class="fa fa-list-alt fa-fw" data-toggle="tooltip" title="{{ $order->customer_note }}"></i>
                                @endif
                                @if(!empty($order->orderDiscount))
                                    <i class="fa fa-gift fa-fw" data-toggle="tooltip" title="{{ $order->orderDiscount->code }}"></i>
                                @endif
                            </td>
                            <th>Phone</th>
                            <th>Name</th>
                            <th colspan="2">Email</th>
                            <th colspan="3">Address</th>
                            <th>District</th>
                        </tr>
                        <tr<?php echo $rowClass; ?>>
                            <td>{{ $order->customer->phone }}</td>
                            <td>{{ $order->orderAddress->name }}</td>
                            <td colspan="2">{{ $order->orderAddress->email }}</td>
                            <td colspan="3">{{ $order->orderAddress->address }}</td>
                            <td>{{ $order->orderAddress->district }}</td>
                        </tr>
                        <tr<?php echo $rowClass; ?>>
                            <th>Pack</th>
                            <td colspan="7">
                                <?php
                                $items = array();
                                ?>
                                @foreach($order->orderItems as $orderItem)
                                    <?php
                                    if(isset($items[$orderItem->meal_pack]))
                                        $items[$orderItem->meal_pack] += 1;
                                    else
                                        $items[$orderItem->meal_pack] = 1;
                                    ?>
                                @endforeach
                                <?php
                                $j = 1;
                                ?>
                                @foreach($items as $packName => $packQuantity)
                                    <?php
                                    if($j == 1)
                                        echo $packQuantity . ' x ' . $packName;
                                    else
                                        echo ' - ' . $packQuantity . ' x ' . $packName;
                                    $j ++;
                                    ?>
                                @endforeach
                            </td>
                        </tr>
                        @if(count($order->orderExtras) > 0)
                            <tr<?php echo $rowClass; ?>>
                                <th>Request</th>
                                <td colspan="7">
                                    <?php
                                    $extras = array();
                                    ?>
                                    @foreach($order->orderExtras as $orderExtra)
                                        <?php
                                        if($orderExtra->code == App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_VALUE)
                                            $extras[] = App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL;
                                        else if($orderExtra->code == App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_VALUE)
                                            $extras[] = App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL;
                                        else
                                            $extras[] = App\Libraries\Util::getRequestChangeIngredient($orderExtra->code);
                                        ?>
                                    @endforeach
                                    <?php
                                    $j = 1;
                                    ?>
                                    @foreach($extras as $extra)
                                        <?php
                                        if($j == 1)
                                            echo $extra;
                                        else
                                            echo ' - ' . $extra;
                                        $j ++;
                                        ?>
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                        <?php
                        $i ++;
                        ?>
                        </tbody>
                    </table>
                @endforeach
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

            $('.DropDownFilterForm').change(function() {

                $('#FilterForm').submit();

            });

        });

    </script>

@stop