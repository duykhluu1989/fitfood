@extends('beta.layouts.main')

@section('content')

    @include('beta.layouts.partials.menu')

    @include('beta.layouts.partials.header', ['banner' => asset('assets/images/page-header/faq.jpg'), 'title' => 'Chính Sách Bảo Mật Thông Tin'])

    <div class="container">
        <div class="row">
            <div id="primary" class="full-width row">
                <div id="content" class="box-shadow">
                    <div class="wrap-faq">

                        @include('beta.layouts.partials.language')

                        <div class="page-title">
                            <h2>Chính Sách Bảo Mật Thông Tin</h2>
                        </div>

                        <p>1. Mục đ&iacute;ch v&agrave; phạm vi thu thập th&ocirc;ng tin</p>
                        <p>Việc thu thập th&ocirc;ng tin qua website: fitfood.vn, inbox tr&ecirc;n fanpage hoặc điện thoại khi kh&aacute;ch muốn đặt h&agrave;ng&nbsp;với mục đ&iacute;ch</p>
                        <ul>
                            <li>Lưu trữ nhằm phục vụ cho mục đ&iacute;ch duyệt đơn h&agrave;ng v&agrave; cung cấp dịch vụ.</li>
                            <li>Gi&uacute;p kh&aacute;ch h&agrave;ng cập nhật th&ocirc;ng tin c&aacute;c chương tr&igrave;nh khuyến m&atilde;i, quảng c&aacute;o, giảm gi&aacute; của shop qu&agrave; việt nhanh nhất.</li>
                            <li>Hỗ trợ chăm s&oacute;c kh&aacute;ch h&agrave;ng, giải quyết c&aacute;c vấn đề khiếu nại li&ecirc;n quan đến c&ocirc;ng ty v&agrave; sản phẩm</li>
                        </ul>
                        <p>2.&nbsp;Phạm vị sử dụng th&ocirc;ng tin</p>
                        <p>Kh&aacute;ch h&agrave;ng đặt h&agrave;ng tại website&nbsp;fitfood.vn&nbsp;sẽ cung cấp c&aacute;c th&ocirc;ng tin sau:</p>
                        <ul>
                            <li>T&ecirc;n họ.</li>
                            <li>Địa chỉ giao h&agrave;ng.</li>
                            <li>Điện thoại.</li>
                            <li></li>
                        </ul>
                        <p>Ch&uacute;ng t&ocirc;i rất coi trọng việc bảo mật th&ocirc;ng tin kh&aacute;ch h&agrave;ng n&ecirc;n ch&uacute;ng t&ocirc;i cam kết sẽ tuyệt đối kh&ocirc;ng tự &yacute; sử dụng th&ocirc;ng tin kh&aacute;ch h&agrave;ng với mục đ&iacute;ch kh&ocirc;ng mang lại lợi &iacute;ch cho kh&aacute;ch h&agrave;ng, ch&uacute;ng t&ocirc;i cam kết kh&ocirc;ng bu&ocirc;n b&aacute;n, trao đổi th&ocirc;ng tin bảo mật của kh&aacute;ch h&agrave;ng cho bất cứ b&ecirc;n thứ ba n&agrave;o. Tuy nhi&ecirc;n, trong một số trường hợp đặc biệt sau, ch&uacute;ng t&ocirc;i c&oacute; thể chia sẻ th&ocirc;ng tin kh&aacute;ch một c&aacute;ch hợp l&yacute; khi:</p>
                        <ul>
                            <li>Được sự đồng &yacute; của kh&aacute;ch h&agrave;ng.</li>
                            <li>Để bảo vệ quyền lợi của c&ocirc;ng ty v&agrave; những đối t&aacute;c của c&ocirc;ng ty: Ch&uacute;ng t&ocirc;i chỉ đưa ra những th&ocirc;ng tin c&aacute; nh&acirc;n của kh&aacute;ch h&agrave;ng khi chắc chắn rằng những th&ocirc;ng tin đ&oacute; c&oacute; thể bảo vệ được quyền lợi, t&agrave;i sản của c&ocirc;ng ty ch&uacute;ng t&ocirc;i v&agrave; những đối t&aacute;c li&ecirc;n quan. Những th&ocirc;ng tin n&agrave;y sẽ được tiết lộ một c&aacute;ch hợp ph&aacute;p theo Ph&aacute;p luật Việt Nam.</li>
                            <li>Theo y&ecirc;u cầu của những cơ quan ch&iacute;nh phủ khi ch&uacute;ng t&ocirc;i thấy n&oacute; ph&ugrave; hợp với ph&aacute;p luật Việt Nam.</li>
                        </ul>
                        <p>Trong một số trường hợp cần thiết phải cung cấp th&ocirc;ng tin kh&aacute;ch h&agrave;ng kh&aacute;c, như c&aacute;c chương tr&igrave;nh khuyến m&atilde;i c&oacute; sự t&agrave;i trợ của một b&ecirc;n thứ ba chẳng hạn, ch&uacute;ng t&ocirc;i sẽ th&ocirc;ng b&aacute;o cho qu&yacute; kh&aacute;ch h&agrave;ng trước khi th&ocirc;ng tin của qu&yacute; kh&aacute;ch được chia sẻ. Q&uacute;y kh&aacute;ch c&oacute; quyền quyết định xem c&oacute; đồng &yacute; chia sẻ th&ocirc;ng tin hoặc tham gia hay kh&ocirc;ng.</p>
                        <p>3.&nbsp;Thời gian lưu th&ocirc;ng tin</p>
                        <p>Fitfood&nbsp;sẽ lưu trữ c&aacute;c Th&ocirc;ng tin c&aacute; nh&acirc;n do Kh&aacute;ch h&agrave;ng cung cấp tr&ecirc;n c&aacute;c hệ thống nội bộ của ch&uacute;ng t&ocirc;i trong qu&aacute; tr&igrave;nh cung cấp dịch vụ cho Kh&aacute;ch h&agrave;ng hoặc cho đến khi ho&agrave;n th&agrave;nh mục đ&iacute;ch thu thập hoặc khi Kh&aacute;ch h&agrave;ng c&oacute; y&ecirc;u cầu hủy c&aacute;c th&ocirc;ng tin đ&atilde; cung cấp.</p>
                        <p>4. Địa chỉ của đơn vị thu thập v&agrave; quản l&yacute; th&ocirc;ng tin c&aacute; nh&acirc;n</p>
                        <p>C&Ocirc;NG TY TR&Aacute;CH NHIỆM HỮU HẠN FITFOOD<br />33 Đường số 14 Khu d&acirc;n cư Binh Hưng, Ấp 2, x&atilde; B&igrave;nh Hưng &ndash; huyện B&igrave;nh Ch&aacute;nh &ndash; TP HCM- VN&nbsp;<br />Điện thoại li&ecirc;n hệ: 0932-788-120 v&agrave; 0971- 248-950<br />Email: info@fitfood.vn</p>
                        <p>5. Phương tiện v&agrave; c&ocirc;ng cụ để người d&ugrave;ng tiếp cận v&agrave; chỉnh sửa dữ liệu c&aacute; nh&acirc;n của m&igrave;nh</p>
                        <p>Kh&aacute;ch h&agrave;ng c&oacute; thể thực hiện c&aacute;c quyền tr&ecirc;n bằng c&aacute;ch tự truy cập v&agrave;o website hoặc li&ecirc;n hệ với ch&uacute;ng t&ocirc;i qua email, địa chỉ li&ecirc;n lạc&nbsp;hoặc số điện thoại&nbsp;được c&ocirc;ng bố tr&ecirc;n website của&nbsp;fitfood.vn</p>
                        <p>6. Cam kết bảo mật th&ocirc;ng tin c&aacute; nh&acirc;n kh&aacute;ch h&agrave;ng</p>
                        <p>Ch&uacute;ng t&ocirc;i cam kết bảo đảm an to&agrave;n th&ocirc;ng tin cho qu&yacute; kh&aacute;ch h&agrave;ng khi đăng k&yacute; th&ocirc;ng tin c&aacute; nh&acirc;n với c&ocirc;ng ty ch&uacute;ng t&ocirc;i. Ch&uacute;ng t&ocirc;i cam kết kh&ocirc;ng trao đổi mua b&aacute;n th&ocirc;ng tin kh&aacute;ch h&agrave;ng v&igrave; mục đ&iacute;ch thương mại. Mọi sự chia sẻ v&agrave; sử dụng th&ocirc;ng tin kh&aacute;ch h&agrave;ng ch&uacute;ng t&ocirc;i cam kết thực hiện theo ch&iacute;nh s&aacute;ch bảo mật của c&ocirc;ng ty. Ch&uacute;ng t&ocirc;i cam kết sẽ khiến qu&yacute; kh&aacute;ch cảm thấy tin tưởng v&agrave; h&agrave;i l&ograve;ng về bảo mật th&ocirc;ng tin c&aacute; nh&acirc;n khi tham gia v&agrave; sử dụng những dịch vụ của c&ocirc;ng ty ch&uacute;ng t&ocirc;i.</p>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop