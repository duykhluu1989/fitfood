@extends('admin.layouts.main')

@section('title', 'List Free Order')

@section('header', 'List Free Order')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-4">
                        @include('admin.layouts.partials.pagination', ['pagination' => $orders])
                    </div>
                    <div class="col-sm-2">
                        <label class="form-control">Total Pack: {{ $orders->total() }}</label>
                    </div>
                    <div class="col-sm-4 form-inline">
                        <div class="form-group">
                            <label for="DatePicker">Week</label>
                            <input id="DatePicker" type="text" class="form-control" value="{{ $date }}" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{ url('admin/freeOrder/export?' . $queryString) }}" data-toggle="tooltip" title="Export Excel" class="btn btn-primary btn-outline">
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
                        <th>District</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Discount Code</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/freeOrder') }}" method="get">
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
                            <td>
                                <input type="text" class="form-control" name="filter[email]" value="{{ (isset($filter['email']) ? $filter['email'] : '') }}" />
                            </td>
                            <td></td>
                        </tr>

                        <input type="hidden" name="date" value="{{ $date }}" />
                        <input type="submit" style="display: none" />
                    </form>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <?php
                        if(isset($duplicateOrderCustomerIds[$order->customer_id]))
                            $rowClass = 'class="warning"';
                        else
                            $rowClass = '';
                        ?>
                        <tr {{ $rowClass }}>
                            <td><a href="{{ url('/admin/order/detail', ['id' => $order->id]) }}" class="btn btn-primary btn-outline">{{ $order->id }}</a></td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->orderAddress->name }}</td>
                            <td>{{ $order->customer->phone }}</td>
                            <td>{{ $order->orderAddress->address }}</td>
                            <td>{{ App\Libraries\Util::getShippingTime($order->shipping_time) }}</td>
                            <td>{{ $order->orderAddress->district }}</td>
                            <td>{{ App\Libraries\Util::getGender($order->orderAddress->gender) }}</td>
                            <td>{{ $order->orderAddress->email }}</td>
                            <td>{{ $order->orderDiscount->code }}</td>
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

                window.location.href = '{{ url('admin/freeOrder') }}?date=' + $(this).val();

            });

        });

    </script>

@stop