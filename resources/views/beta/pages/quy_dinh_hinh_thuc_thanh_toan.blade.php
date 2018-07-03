@extends('beta.layouts.main')

@section('content')

    @include('beta.layouts.partials.menu')

    @include('beta.layouts.partials.header', ['banner' => asset('assets/images/page-header/faq.jpg'), 'title' => 'Quy Định & Hình Thức Thanh Toán'])

    <div class="container">
        <div class="row">
            <div id="primary" class="full-width row">
                <div id="content" class="box-shadow">
                    <div class="wrap-faq">

                        @include('beta.layouts.partials.language')

                        <div class="page-title">
                            <h2>Quy Định & Hình Thức Thanh Toán</h2>
                        </div>

                        <ol>
                            <li><strong><u>H&igrave;nh thức thanh to&aacute;n</u></strong></li>
                        </ol>
                        <p>Quý khách vui lòng thanh toán đơn hàng bao g&ocirc;̀m phí v&acirc;̣n chuy&ecirc;̉n (áp dụng t&ugrave;y khu vực) &nbsp;v&agrave;o ng&agrave;y đầu ti&ecirc;n khi nhận được đơn h&agrave;ng, bằng một trong c&aacute;c h&igrave;nh thức sau:</p>
                        <p>COD: thanh to&aacute;n tiền mặt v&agrave;o c&aacute;c ng&agrave;y trong tuần khi giao thức ăn</p>
                        <p>mPOS: li&ecirc;n kết với Payoo quẹt thẻ tại chỗ</p>
                        <p>Chuyển khoản: Ng&acirc;n h&agrave;ng Vietcombank</p>
                        <img src="{{ asset('assets/images/chinh-sach/tt.png') }}" alt="Fitfood" />
                        <p>T&ecirc;n t&agrave;i khoản: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>PHẠM THỊ NGỌC HIẾU</strong></p>
                        <p>Số t&agrave;i khoản:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>007101176931</strong></p>
                        <p>Chi nh&aacute;nh: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Hồ Chí Minh</strong></p>
                        <p>&nbsp;</p>
                        <p>Đối với trường hợp chuyển khoản, sau khi thanh to&aacute;n, quý khách vui lòng th&ocirc;ng báo cho Fitfood bi&ecirc;́t v&ecirc;̀ th&ocirc;ng tin giao dịch g&ocirc;̀m&nbsp;t&ecirc;n chủ tài khoản chuy&ecirc;̉n ti&ecirc;̀n, s&ocirc;́ ti&ecirc;̀n đã chuy&ecirc;̉n, ng&acirc;n hàng chuy&ecirc;̉n ti&ecirc;̀n&nbsp;bằng cách</p>
                        <ul>
                            <li>Gọi tới s&ocirc;́ đi&ecirc;̣n thoại&nbsp;<strong>0932 788 120</strong></li>
                            <li>Gửi email theo địa chỉ:&nbsp;<a href="mailto:info@fitfood.vn">info@fitfood.vn</a></li>
                        </ul>
                        <ol start="2">
                            <li><strong><u>Quy định hủy h&agrave;ng v&agrave; ho&agrave;n tiền</u></strong></li>
                        </ol>
                        <p><strong>Ch&iacute;nh sạch hủy h&agrave;ng</strong></p>
                        <p>Fitfood sẽ chấp nhận hủy đơn h&agrave;ng v&agrave;o c&aacute;c ng&agrave;y c&ograve;n lại của kh&aacute;ch với điều kiện kh&aacute;ch b&aacute;o lại <u>trước 12h trưa</u> của ng&agrave;y h&ocirc;m trước. Fitfood chỉ hủy đợn h&agrave;ng của bạn trong trường hợp bạn ăn kh&ocirc;ng hợp khẩu vị, hoặc bận việc phải đi c&ocirc;ng t&aacute;c.</p>
                        <p><strong>Ch&iacute;nh s&aacute;ch ho&agrave;n tiền:</strong></p>
                        <ul>
                            <li>COD: người giao h&agrave;ng sẽ trả lai tiền v&agrave;o ng&agrave;y h&ocirc;m sau, sau khi nhận được th&ocirc;ng tin hủy h&agrave;ng của kh&aacute;ch</li>
                            <li>Chuyển khoản: Fitfood sẽ xin th&ocirc;ng tin v&agrave; chuyển khoản trả lại tiền cho kh&aacute;ch h&agrave;ng</li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop