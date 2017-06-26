@extends('beta.layouts.main')

@section('content')

    @include('beta.layouts.partials.menu')

    <div class="container">
        <div class="row">
            <div id="primary" class="full-width">
                <div id="content" class="box-shadow">
                    <div class="wrap-order">
                        <div class="page-title">
                            <h2>Order Confirmation</h2>
                        </div>
                        <div class="frm-order">
                            <br />
                            <p>
                                Cám ơn bạn đã order tại Fitfood Vietnam. Một email tự động đã được gửi tới email bạn đăng ký | Thank you for ordering at Fitfood Vietnam. An automatic email has been sent to your email address.
                            </p>
                            <br />
                            <p>
                                Fitfood sẽ không gọi điện xác nhận. Nếu bạn nhận được email được gửi từ hệ thống của Fitfood (order@fitfood.vn), đơn hàng của bạn đã được ghi nhận và chúng tôi sẽ giao phần ăn theo như thông tin đã đăng ký. Xin cám ơn!
                            </p>
                            <p>
                                -------------
                            </p>
                            <p>
                                Please note that we will not call our customers for confirmation. If you receive an automated email sending from our system (order@fitfood.vn), it means we have received your order. We will deliver the package as your request. Thank You!
                            </p>
                            <br />
                            <ul>
                                <li>Tên | Name: {{ $name }}</li>
                                <li>Số điện thoại | Phone: <a href="tel:{{ $phone }}" value="{{ $phone }}" target="_blank">{{ $phone }}</a></li>
                                <li>Email: {{ $email }}</li>
                                <li>Địa chỉ giao hàng | Delivery address: {{ $address }}</li>
                                <li>Quận | District: {{ $district }}</li>
                                <li>Thời gian giao hàng | Delivery time: {{ $deliveryTime }}</li>
                            </ul>
                            <br />
                            <p style="color: red">​Đơn hàng của bạn sẽ được bắt đầu giao vào ngày | Your order will be delivered starting from: {{ $startShippingDate }}​</p>
                            <br />
                            <p>
                                Vui lòng kiểm tra lại thông tin bên trên, nếu có bất kỳ thông tin nào bạn mong muốn thay đổi, đừng ngần ngại gọi cho Fitfood | Please check the info above again, if there is anything you would like to change, call Us
                                <br />
                                (+84) 9 3278 8120
                                <br />
                                (+84) 9 7124 8950
                                <br />
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop