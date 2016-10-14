@extends('admin.layouts.main')

@section('title', 'List Customer')

@section('header', 'List Customer')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $customers])
                    </div>
                    <div class="col-sm-6">
                        <div class="col-sm-4">
                            <a href="{{ url('admin/customer/export?' . $queryString) }}" data-toggle="tooltip" title="Export Excel" class="btn btn-primary btn-outline">
                                <i class="fa fa-download fa-fw"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer ID</th>
                        <th>Phone</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Orders</th>
                        <th>Spent</th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/customer') }}" method="get">
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[customer_id]" value="{{ (isset($filter['customer_id']) ? $filter['customer_id'] : '') }}" />
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
                                <input type="text" class="form-control" name="filter[address]" value="{{ (isset($filter['address']) ? $filter['address'] : '') }}" />
                            </td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[gender]">
                                    <option value=""></option>
                                    @foreach(App\Libraries\Util::getGender() as $value => $label)
                                        @if(isset($filter['gender']) && $filter['gender'] == $value)
                                            <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>

                        <input type="submit" style="display: none" />
                    </form>
                    </thead>
                    <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td>
                                <a href="{{ url('admin/customer/detail', ['id' => $customer->id]) }}" class="btn btn-primary btn-outline">{{ $customer->id }}</a>
                            </td>
                            <td>{{ $customer->customer_id }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>{{ App\Libraries\Util::getGender($customer->gender) }}</td>
                            <td>{{ $customer->orders_count }}</td>
                            <td>{{ App\Libraries\Util::formatMoney($customer->total_spent) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $customers])
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

        });

    </script>

@stop