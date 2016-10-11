@extends('admin.layouts.main')

@section('title', 'Assign Shipping')

@section('header', 'Assign Shipping')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $orders])
                    </div>
                    <div class="col-sm-6 form-inline">
                        <div class="form-group">
                            <label for="DatePicker">Week</label>
                            <input id="DatePicker" type="text" class="form-control" value="{{ $date }}" readonly="readonly" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Set Shipper</th>
                        <th>Shipper</th>
                        <th>Order</th>
                        <th>Order ID</th>
                        <th>Phone</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>
                            <a href="{{ url('assignShipping?' . $queryString . (isset($sort['district']) ? ($sort['district'] == 'ASC' ? '&sort[district]=DESC' : '') : '&sort[district]=ASC')) }}">
                                District
                            </a>
                        </th>
                        <th>
                            <a href="{{ url('assignShipping?' . $queryString . (isset($sort['latlong']) ? ($sort['latlong'] == 'ASC' ? '&sort[latlong]=DESC' : '') : '&sort[latlong]=ASC')) }}">
                                LatLong
                            </a>
                        </th>
                        <th>Priority</th>
                        <th>Set Priority</th>
                    </tr>
                    </thead>
                    <tbody>
                    <form id="FilterForm" action="{{ url('assignShipping') }}" method="get">
                        <tr>
                            <td>
                                <select class="form-control" id="AssignShipperDropDownAll">
                                    <option value=""></option>
                                    @foreach(App\Models\Shipper::getDropDownActiveShipper() as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[shipper]">
                                    <option value=""></option>
                                    <option{{ ((isset($filter['shipper']) && $filter['shipper'] == 'NO ASSIGN') ? ' selected="selected"' : '') }} value="NO ASSIGN">NO ASSIGN</option>
                                    @foreach(App\Models\Shipper::getDropDownActiveShipper() as $value => $label)
                                        <option{{ ((isset($filter['shipper']) && $filter['shipper'] == $value) ? ' selected="selected"' : '') }} value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[district]">
                                    <option value=""></option>
                                    @foreach(App\Models\Area::getModelActiveArea() as $area)
                                        <option{{ ((isset($filter['district']) && $filter['district'] == $area->name) ? ' selected="selected"' : '') }} value="{{ $area->name }}">{{ $area->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" id="AssignPriorityInputAll" />
                            </td>
                        </tr>

                        <input type="hidden" name="date" value="{{ $date }}" />
                        <input type="submit" style="display: none" />
                    </form>
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <select class="form-control AssignShipperDropDown" id="AssignShipperDropDown_{{ $order->id }}">
                                    @if(empty($order->shipper_id))
                                        <option value=""></option>
                                    @endif
                                    @foreach(App\Models\Shipper::getDropDownActiveShipper() as $value => $label)
                                        <option{{ ((!empty($order->shipper_id) && $order->shipper_id == $value) ? ' selected="selected"' : '') }} value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="ShipperNameColumn" id="ShipperNameColumn_{{ $order->id }}">{{ (!empty($order->shipper) ? $order->shipper->name : '') }}</td>
                            <td>
                                <a href="{{ url('order/detail', ['id' => $order->id]) }}" class="btn btn-primary btn-outline">{{ $order->id }}</a>
                            </td>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->customer->phone }}</td>
                            <td>{{ $order->orderAddress->name }}</td>
                            <td>{{ $order->orderAddress->address }}</td>
                            <td>{{ $order->orderAddress->district }}</td>
                            <td>{{ $order->orderAddress->latitude }}<br />{{ $order->orderAddress->longitude }}</td>
                            <td class="PriorityNumberColumn" id="PriorityNumberColumn_{{ $order->id }}">{{ $order->shipping_priority }}</td>
                            <td>
                                <input type="text" class="form-control AssignPriorityInput" id="AssignPriorityInput_{{ $order->id }}" value="{{ $order->shipping_priority }}" />
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $orders])
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

                window.location.href = '{{ url('assignShipping') }}?date=' + $(this).val();

            });

            $('.DropDownFilterForm').change(function() {

                $('#FilterForm').submit();

            });

            $('#AssignShipperDropDownAll').change(function() {

                var elem = $(this);
                var elemVal = elem.val();
                var elemLabel = elem.find('option:selected').text();

                if(showConfirmMessage() && elemVal != '')
                {
                    showLoadingScreen();

                    $.ajax({

                        url: '{{ url('assignShipping/order') }}',
                        type: 'post',
                        data: '_token={{ csrf_token() }}&order=all&shipper=' + elemVal + '<?php echo $queryString; ?>',
                        success: function(result) {

                            if(result)
                            {
                                $('.AssignShipperDropDown').each(function() {

                                    $(this).val(elemVal);

                                });


                                $('.ShipperNameColumn').each(function() {

                                    $(this).html(elemLabel);

                                });

                                closeLoadingScreen();
                            }

                        }

                    });
                }

                elem.val('');

            });

            $('.AssignShipperDropDown').change(function() {

                var elem = $(this);
                var elemVal = elem.val();
                var elemLabel = elem.find('option:selected').text();

                var orderIdArr = elem.prop('id').split('_');

                if(elemVal != '')
                {
                    showLoadingScreen();

                    $.ajax({

                        url: '{{ url('assignShipping/order') }}',
                        type: 'post',
                        data: '_token={{ csrf_token() }}&order=' + orderIdArr[1] + '&shipper=' + elemVal + '&date=<?php echo $date; ?>',
                        success: function(result) {

                            if(result)
                            {
                                $('#ShipperNameColumn_' + orderIdArr[1]).html(elemLabel);

                                closeLoadingScreen();
                            }

                        }

                    });
                }
                else
                    return false;

            });

            $('#AssignPriorityInputAll').change(function() {

                var elem = $(this);
                var elemVal = elem.val();

                if(showConfirmMessage() && elemVal != '' && !isNaN(elemVal))
                {
                    showLoadingScreen();

                    $.ajax({

                        url: '{{ url('assignShipping/priority') }}',
                        type: 'post',
                        data: '_token={{ csrf_token() }}&order=all&priority=' + elemVal + '<?php echo $queryString; ?>',
                        success: function(result) {

                            if(result)
                            {
                                $('.AssignPriorityInput').each(function() {

                                    $(this).val(elemVal);

                                });


                                $('.PriorityNumberColumn').each(function() {

                                    $(this).html(elemVal);

                                });

                                closeLoadingScreen();
                            }

                        }

                    });
                }

                elem.val('');

            });

            $('.AssignPriorityInput').change(function() {

                var elem = $(this);
                var elemVal = elem.val();

                var orderIdArr = elem.prop('id').split('_');

                if(elemVal != '' && !isNaN(elemVal))
                {
                    showLoadingScreen();

                    $.ajax({

                        url: '{{ url('assignShipping/priority') }}',
                        type: 'post',
                        data: '_token={{ csrf_token() }}&order=' + orderIdArr[1] + '&priority=' + elemVal + '&date=<?php echo $date; ?>',
                        success: function(result) {

                            if(result)
                            {
                                $('#PriorityNumberColumn_' + orderIdArr[1]).html(elemVal);

                                closeLoadingScreen();
                            }

                        }

                    });
                }
                else
                    return false;

            });

        });

    </script>

@stop