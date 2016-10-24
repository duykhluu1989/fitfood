@extends('admin.layouts.main')

@section('title', 'List Discount')

@section('header', 'List Discount')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $discounts])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/discount/create') }}" data-toggle="tooltip" title="New Discount" class="btn btn-primary btn-outline">
                            <i class="fa fa-plus fa-fw"></i>
                        </a>
                        <a href="{{ url('admin/discount/create/many') }}" data-toggle="tooltip" title="New Many Discount" class="btn btn-primary btn-outline">
                            <i class="fa fa-random fa-fw"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Used</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Customer ID</th>
                        <th>Description</th>
                        <th>Active</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/discount') }}" method="get">
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[code]" value="{{ (isset($filter['code']) ? $filter['code'] : '') }}" />
                            </td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[type]">
                                    <option value=""></option>
                                    @foreach(App\Libraries\Util::getDiscountType() as $value => $label)
                                        @if(isset($filter['type']) && $filter['type'] == $value)
                                            <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[description]" value="{{ (isset($filter['description']) ? $filter['description'] : '') }}" />
                            </td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[status]">
                                    <option value=""></option>
                                    @foreach(App\Libraries\Util::getStatus() as $value => $label)
                                        @if(isset($filter['status']) && $filter['status'] !== '' && $filter['status'] == $value)
                                            <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        <input type="submit" style="display: none" />
                    </form>
                    </thead>
                    <tbody>
                    @foreach($discounts as $discount)
                        <tr>
                            <td>
                                <a href="{{ url('admin/discount/edit', ['id' => $discount->id]) }}" class="btn btn-primary btn-outline">{{ $discount->id }}</a>
                            </td>
                            <td>{{ $discount->code }}</td>
                            <td>{{ $discount->type }}</td>
                            <td>{{ ($discount->type == App\Libraries\Util::DISCOUNT_TYPE_FIXED_AMOUNT_VALUED ? App\Libraries\Util::formatMoney($discount->value) : $discount->value) }}</td>
                            <td>{{ $discount->times_used }}</td>
                            <td>{{ $discount->start_time }}</td>
                            <td>{{ $discount->end_time }}</td>
                            <td>{{ !empty($discount->customer) ? $discount->customer->customer_id : '' }}</td>
                            <td>{{ $discount->description }}</td>
                            <td<?php echo ($discount->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?>></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $discounts])
            </div>
        </div>
    </div>

@stop

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('.DropDownFilterForm').change(function() {

                $('#FilterForm').submit();

            });

            @if($exportData != null)
                window.location = '<?php echo url('admin/discount/export'); ?>';
            @endif

        });

    </script>

@stop