@extends('web.layouts.main')

@section('content')

    <div class="col-sm-12">
        <div class="col-sm-6 col-sm-offset-3">
            <div id="LogoThankyou">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Fitfood" width="100%" height="100%" />
            </div>
            <div id="LogoTitleThankyou">
                ORDER CONFIRMATION
            </div>
        </div>
        <div class="col-sm-12 row">
            <div class="col-sm-8 col-sm-offset-2">
                <br />
                <p>
                    Cám ơn bạn đã order tại Fitfood Vietnam. Một email tự động đã được gửi tới email bạn đăng ký | Thank you for ordering at Fitfood Vietnam. An automatic email has been sent to your email address.
                </p>
                <br />
                <ul>
                    <li>Tên | Name: {{ $name }}</li>
                    <li>Số điện thoại | Phone: <a href="tel:{{ $phone }}" value="{{ $phone}}" target="_blank">{{ $phone }}</a></li>
                    <li>Email: {{ $email }}</li>
                    <li>Địa chỉ giao hàng | Delivery address: {{ $address }}</li>
                    <li>Khẩu phần mong muốn | Your desired package: {{ $mealPacks }}</li>
                    <li>Hình thức thanh toán | Payment Method: {{ $paymentGateway }}</li>
                    <li>Thời gian giao hàng | Delivery time: {{ $deliveryTime }}</li>
                    <li>Yêu cầu đặc biệt | Special Request: {{ $extraRequest }}</li>
                    <li>Tổng giá tiền | Total bill: {{ $totalPrice }}</li>
                    <li>Ghi chú | Note: {{ $note }}</li>
                </ul>
                <br />
                <p style="color: red">​Đơn hàng của bạn sẽ được bắt đầu giao vào ngày | Your order will be delivered starting from: {{ $startShippingDate }}​</p>
                @if(!empty($bankNumber))
                    <br />
                    <p>
                        Thông tin chuyển khoản | Bank transfer information
                    </p>
                    <br />
                    <ul>
                        <li>Tên tài khoản | Account name: {{ App\Libraries\Util::BANK_TRANSFER_ACCOUNT_NAME }}</li>
                        <li>Số tài khoản | Account number: {{ $bankNumber }}</li>
                        <li>Vui lòng ghi trong phần thông tin chuyển khoản là: [Tên] [Số điện thoại] TT FITFOOD TUẦN [XX / XX] | Please note in the transfer information: [Name] [Phone] TT FITFOOD WEEK [XX / XX]</li>
                    </ul>
                @endif
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

    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1665387320368867');
        fbq('track', "PageView");
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1665387320368867&ev=PageView&noscript=1" />
    </noscript>

    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 940209987;
        var google_conversion_language = "en";
        var google_conversion_format = "3";
        var google_conversion_color = "ffffff";
        var google_conversion_label = "YS_7COfzxWcQw-6pwAM";
        var google_remarketing_only = false;
        /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/940209987/?label=YS_7COfzxWcQw-6pwAM&amp;guid=ON&amp;script=0" />
        </div>
    </noscript>

@stop