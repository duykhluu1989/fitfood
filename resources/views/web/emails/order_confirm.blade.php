<p>Hi {{ $name }},</p>
<p>Cám ơn bạn đã order tại Fitfood.vn, Email này xác nhận thông tin order của bạn đã được ghi nhận trên hệ thống của chúng tôi. Vui lòng không trả lời lại, bạn kiểm tra lại thông tin bên dưới và đừng ngần ngại gọi cho chúng tôi 0932 788 120 nếu bạn muốn thay đổi thông tin.</p>
<p>Thanks for placing your order at Fitfood.vn. This automated email confirms that we have recorded your order information in our system. Please kindly check the information below and feel free to contact us 0932 788 120 if you would like to change any info.</p>
<ul>
    <li>Tên | Name: {{ $name }}</li>
    <li>Số điện thoại | Phone: <a href="tel:{{ $phone }}" value="{{ $phone}}" target="_blank">{{ $phone }}</a></li>
    <li>Địa chỉ giao hàng | Delivery address: {{ $address }}</li>
    <li>Quận | District: {{ $district }}</li>
    <li>Khẩu phần mong muốn | Your desired package: {{ $mealPacks }}</li>
    <li>Hình thức thanh toán | Payment Method: {{ $paymentGateway }}</li>
    <li>Thời gian giao hàng | Delivery time: {{ $deliveryTime }}</li>
    <li>Yêu cầu đặc biệt | Special Request: {{ $extraRequest }}</li>
    <li>Tổng giá tiền | Total bill: {{ $totalPrice }} ({{ $normalMenuDays }} ngày + phí giao hàng | {{ $normalMenuDays }} days + ship fee)</li>
    <li>Ghi chú | Note: {{ $note }}</li>
</ul>
<p style="color: red">​Đơn hàng của bạn sẽ được bắt đầu giao vào ngày | Your order will be delivered starting from: {{ $startShippingDate }}​</p>
@if(!empty($bankNumber))
    <p>Thông tin chuyển khoản | Bank transfer information</p>
    <ul>
        <li>Tên tài khoản | Account name: {{ App\Libraries\Util::BANK_TRANSFER_ACCOUNT_NAME }}</li>
        <li>Số tài khoản | Account number: {{ $bankNumber }}</li>
        <li>Vui lòng ghi trong phần thông tin chuyển khoản là: [Tên] [Số điện thoại] TT FITFOOD TUẦN [XX / XX] | Please note in the transfer information: [Name] [Phone] TT FITFOOD WEEK [XX / XX]</li>
    </ul>
@endif
<p>Chúng tôi hy vọng bạn sẽ hài lòng với dịch vụ của Fitfood | We hope you enjoy our service !</p>
<p><i><span style="color:rgb(75,79,86);font-family:helvetica,arial,sans-serif;font-size:12px;line-height:15.36px;white-space:pre-wrap;background-color:rgb(254,254,254)"><b><u>Note:</u></b> Đây là email thông báo tự động được gửi từ hệ thống Fitfood đến địa chỉ <a href="mailto:{{ $email }}" target="_blank">{{ $email }}</a> của bạn, vui lòng không trả lời email này. Xin cám ơn |  This is an automated message sent from our system to your email address : <a href="mailto:{{ $email }}" target="_blank">{{ $email }}</a>. Please do not reply. Thank you ! </span><br></i></p>
<p><span style="color:rgb(75,79,86);font-family:helvetica,arial,sans-serif;font-size:12px;line-height:15.36px;white-space:pre-wrap;background-color:rgb(254,254,254)"><i>Bạn vui lòng tham khảo các thắc mắc thường gặp tại: <a href="http://fitfood.vn/faq" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=vi&amp;q=http://fitfood.vn/faq&amp;source=gmail&amp;ust=1466753690556000&amp;usg=AFQjCNH6xbLdAwb6ts3-gRORnAF5_Rx6Cg">fitfood.vn/faq</a>  | For our service inquiries, please check out our English FAQ: <a href="http://fitfood.vn/faq.en" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=vi&amp;q=http://fitfood.vn/faq.en&amp;source=gmail&amp;ust=1466753690556000&amp;usg=AFQjCNE2e9_2CiqoR0KHno2Z81kJQ9rwVA">fitfood.vn/faq.en</a></i><br></span></p>
<p><img src="{{ asset('assets/img/logo.png') }}" height="106" width="106" alt="Fitfood" /></p>
<p style="font-weight:normal;font-size:12.8px"><b style="font-size:12.8px"><span style="border-collapse:collapse"><div style="font-weight:normal;font-size:12.8px;display:inline!important"><b><font face="trebuchet ms, sans-serif"><font color="#666666" size="4">&nbsp;</font><font color="#444444" size="4">FITFOOD VIETNAM &nbsp;</font></font></b></div></span></b></p>
<p style="font-size:12.8px;font-weight:normal"><font face="trebuchet ms, sans-serif" color="#999999">&nbsp;&nbsp;</font><font color="#666666"><font face="trebuchet ms, sans-serif">Weekly meals for a healthy lifestyle |&nbsp;</font><span style="font-family:'trebuchet ms',sans-serif;font-size:12.8px">Green * Fit * Healthy</span></font></p>
<p style="font-size:12.8px;font-weight:normal"><font face="trebuchet ms, sans-serif" color="#999999"><span style="font-size:12.8px">&nbsp;&nbsp;<a href="http://www.fitfood.vn/" style="color:rgb(17,85,204)" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=vi&amp;q=http://www.fitfood.vn/&amp;source=gmail&amp;ust=1465454471587000&amp;usg=AFQjCNFSK6WTLn6XROGyMKjPHSHbOWA8Ow">www.fitfood.vn</a>&nbsp;|&nbsp;<a href="http://www.facebook.com/fitfoodvietnam" style="color:rgb(17,85,204)" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=vi&amp;q=http://www.facebook.com/fitfoodvietnam&amp;source=gmail&amp;ust=1465454471587000&amp;usg=AFQjCNF1gNUGIUvSURLdc6yZgeHHWdXsvg">www.<wbr>facebook.com/fitfoodvietnam</a></span><br></font></p>
<p style="font-size:12.8px;font-weight:normal"><font face="trebuchet ms, sans-serif" color="#999999">&nbsp;&nbsp;</font><span style="color:rgb(102,102,102);font-family:'trebuchet ms',sans-serif;font-size:12.8px">Order Now</span><font style="font-size:12.8px" face="trebuchet ms, sans-serif" color="#999999">:&nbsp;</font><a href="tel:0971%20248%20950" value="+84971248950" style="font-size:12.8px;font-family:'trebuchet ms',sans-serif" target="_blank">0971 248 950</a><span style="font-size:12.8px;color:rgb(102,102,102);font-family:'trebuchet ms',sans-serif">&nbsp;-&nbsp;</span><a href="tel:0932%20788%20120" value="+84932788120" style="font-size:12.8px;font-family:'trebuchet ms',sans-serif" target="_blank">0932 788 120</a></p>