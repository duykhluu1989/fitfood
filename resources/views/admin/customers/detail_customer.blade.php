@extends('admin.layouts.main')

@section('title', 'Detail Customer')

@section('header', 'Detail Customer - ' . $customer->customer_id)

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="panel-title">General</h3>
                    </div>
                    <div class="col-sm-6">
                        <div class="col-sm-4">
                            <a href="{{ url('admin/customer/edit', ['id' => $customer->id]) }}" data-toggle="tooltip" title="Edit Customer" class="btn btn-primary btn-outline">
                                <i class="fa fa-edit fa-fw"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>Phone</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Created</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $customer->customer_id }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ App\Libraries\Util::getGender($customer->gender) }}</td>
                        <td>{{ $customer->created_at }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">Address</th>
                        <th>District</th>
                    </tr>
                    <tr>
                        <td colspan="5">{{ $customer->address }}</td>
                        <td>{{ $customer->district }}</td>
                    </tr>
                    <tr>
                        <th colspan="3">Address Google</th>
                        <th colspan="3">LatLong</th>
                    </tr>
                    <tr>
                        <td colspan="3">{{ $customer->address_google }}</td>
                        <td colspan="3">{{ $customer->latitude . ' - ' . $customer->longitude }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Order</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Orders</th>
                        <th>Spent</th>
                        <th>First</th>
                        <th>Last</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $customer->orders_count }}</td>
                        <td>{{ App\Libraries\Util::formatMoney($customer->total_spent) }}</td>
                        <td>
                            @if(!empty($customer->firstOrder))
                                <a href="{{ url('admin/order/detail', ['id' => $customer->firstOrder->id]) }}" class="btn btn-primary btn-outline">{{ $customer->firstOrder->id }}</a>
                            @endif
                        </td>
                        <td>
                            @if(!empty($customer->lastOrder))
                                <a href="{{ url('admin/order/detail', ['id' => $customer->lastOrder->id]) }}" class="btn btn-primary btn-outline">{{ $customer->lastOrder->id }}</a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th colspan="4">List Orders</th>
                    </tr>
                    <tr>
                        <td colspan="4">
                            @foreach($customer->orders as $order)
                                <a href="{{ url('admin/order/detail', ['id' => $order->id]) }}" class="btn btn-primary btn-outline">{{ $order->id }}</a>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop