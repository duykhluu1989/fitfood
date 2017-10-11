@extends('beta.layouts.main')

@section('content')

    @include('beta.layouts.partials.menu')

    @include('beta.layouts.partials.header', ['banner' => asset('assets/images/page-header/faq.jpg'), 'title' => 'Chính Sách & Quy Định Chung'])

    <div class="container">
        <div class="row">
            <div id="primary" class="full-width row">
                <div id="content" class="box-shadow">
                    <div class="wrap-faq">

                        @include('beta.layouts.partials.language')

                        <div class="page-title">
                            <h2>Chính Sách & Quy Định Chung</h2>
                        </div>

                        <p><strong><u>1. M&ocirc; h&igrave;nh hoạt động:</u></strong></p>
                        <p style="padding-left: 30px;"><strong><u>a) M&ocirc; h&igrave;nh hoạt động</u></strong></p>
                        <ul>
                            <li>Fitfood chuy&ecirc;n cung cấp c&aacute;c bữa ăn sạch h&agrave;ng tuần được chuẩn bị sẵn, gi&uacute;p bạn theo đuổi một phong c&aacute;ch sống khỏe v&agrave; c&acirc;n bằng dinh dưỡng.</li>
                            <li>Fitfood chỉ nhận order cho nguy&ecirc;n tuần (5 ng&agrave;y từ thứ 2 đến thứ 6), v&agrave; hiện tại Fitfood chưa nhận order lẻ từng ng&agrave;y hoặc từng bữa.</li>
                            <li>Tất cả c&aacute;c bữa ăn đều được cấp đ&ocirc;ng nhằm đảm bảo an to&agrave;n thực phẩm trong qu&aacute; tr&igrave;nh vận chuyển. Bạn vui l&ograve;ng bảo quản trong tủ lạnh v&agrave; h&acirc;m n&oacute;ng trước khi ăn.</li>
                            <li>Lưu &yacute;: Để đảm bảo chất lượng phục vụ với quy m&ocirc; nhỏ của bếp, Fitfood sẽ ngưng nhận c&aacute;c đơn h&agrave;ng mới từ thứ 7 tuần trước. C&aacute;c đơn h&agrave;ng sau thời gian n&agrave;y sẽ được tự động dời sang tuần sau, mong bạn th&ocirc;ng cảm!</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p style="padding-left: 30px;"><strong><u>b) C&aacute;c g&oacute;i thức ăn</u></strong></p>
                        <p>Hiện tại Fitfood cung cấp c&aacute;c g&oacute;i ăn như sau:</p>
                        <p>1/ G&oacute;i FULL (3 bữa/ng&agrave;y) - 700k/tuần</p>
                        <p>2/ G&oacute;i FIT (2 bữa/ng&agrave;y, trưa &amp; tối, s&aacute;ng &amp; trưa, hoặc s&aacute;ng &amp; tối) - 550k/tuần</p>
                        <p>3/ G&oacute;i MEAT LOVER (Gấp đ&ocirc;i lượng protein, 2 bữa trưa - tối bao gồm tinh bột phức trong c&aacute;c buổi trưa) - 900k/tuần</p>
                        <p>4/ G&oacute;i VEG (2 bữa chay/ng&agrave;y, trưa v&agrave; tối) &ndash; 550k/tuần</p>
                        <p>&nbsp;</p>
                        <p>Ngo&agrave;i ra, khi kh&aacute;ch đặt h&agrave;ng c&aacute;c g&oacute;i ăn c&oacute; thể y&ecirc;u cầu c&aacute;c dịch vụ đi k&egrave;m:</p>
                        <p>1/ Y&ecirc;u cầu đăc biệt ( d&agrave;nh cho kh&aacute;ch dị ứng với thức ăn c&aacute;c loại thịt, c&aacute;): ph&iacute; 50k/tuần</p>
                        <p>2/ Đổi bữa linh hoạt: d&agrave;nh cho kh&aacute;ch muốn ăn linh hoạt theo từng ng&agrave;y: Thứ ăn đặt trưa &ndash; tối, thứ 3 ăn s&aacute;ng &ndash; trưa&hellip;..)</p>
                        <p>3/ Th&ecirc;m phần ăn s&aacute;ng cho g&oacute;i MEAT: g&oacute;i MEAT chỉ c&oacute; 2 bữa/ ng&agrave;y, trưa &ndash; tối n&ecirc;n kh&aacute;ch muốn ăn th&ecirc;m phần ăn s&aacute;ng th&igrave; sẽ c&oacute; thể đặt th&ecirc;m bữa s&aacute;ng với chi ph&iacute; cộng th&ecirc;m l&agrave; 200k/tuần</p>
                        <p>&nbsp;</p>
                        <p>Sản phẩm phụ <em>(chỉ b&aacute;n k&egrave;m với g&oacute;i thức ăn):</em></p>
                        <p>1/ Nước tr&aacute;i c&acirc;y (giao 3 ng&agrave;y/ tuần , thứ 2 &ndash; thứ 4, thứ 6) &ndash; 150k/tuần</p>
                        <p>2/ Sữa từ hạt (giao 5 ng&agrave;y/ tuần, từ thứ 2 đến thứ 6) &ndash; 150k/tuần</p>
                        <p>3/ Hạt dinh dưỡng: 149k/sản phẩm</p>
                        <p>&nbsp;</p>
                        <p><strong><u>2. Quy định về đặt h&agrave;ng</u></strong></p>
                        <ul>
                            <li>Fitfood chỉ nhận order theo tuần, kh&ocirc;ng nhận lẻ 1 bữa/ tuần hay 1 ng&agrave;y</li>
                            <li>Fitfood chốt đơn đặt h&agrave;ng 12 giờ tối thứ 7 v&agrave; bắt đầu giao từ thứ 2 h&agrave;ng tuần</li>
                            <li>Đối với những ng&agrave;y lễ rơi v&agrave;o 1 trong c&aacute;c ng&agrave;y từ thứ 2 đến thứ 6, Fitfood sẽ trừ tiền phần ăn v&agrave;o những ng&agrave;y nghỉ lễ v&agrave; sẽ kh&ocirc;ng giao c&aacute;c phần ăn trong những ng&agrave;y đ&oacute;.</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p style="padding-left: 30px;"><strong><u>a) Hướng dẫn y&ecirc;u cầu tư vấn hoặc đặt h&agrave;ng</u></strong></p>
                        <p>Bạn c&oacute; thể y&ecirc;u cầu tư vấn hoặc đặt h&agrave;ng trực tuyến với Fitfood th&ocirc;ng qua c&aacute;c h&igrave;nh thức sau:</p>
                        <p><u>C&aacute;ch 1:</u> Nhận tư vấn th&ocirc;ng qua điện thoại <strong>0932 788 120 - 0938 074 120</strong></p>
                        <ul>
                            <li>Tư vấn vi&ecirc;n sẽ trả lời c&aacute;c yều cầu của kh&aacute;ch h&agrave;ng đồng thời sẽ ghi nhận lại th&ocirc;ng tin của kh&aacute;ch h&agrave;ng nếu kh&aacute;ch h&agrave;ng muốn đặt h&agrave;ng th&ocirc;ng qua điện thoại.</li>
                            <li>Tư vấn vi&ecirc;n sẽ hỗ trợ điền th&ocirc;ng tin gi&ugrave;m kh&aacute;ch tr&ecirc;n đơn đặt h&agrave;ng v&agrave; hệ thống sẽ tự động gửi 1 email x&aacute;c nhận đợn h&agrave;ng đến cho kh&aacute;ch h&agrave;ng sau khi đơn h&agrave;ng được đặt th&agrave;nh c&ocirc;ng</li>
                        </ul>
                        <p><u>C&aacute;ch 2:</u> Nhận tư vấn qua Inbox Fanpage: facebook.com/fitfoodvietnam</p>
                        <img src="{{ asset('assets/images/chinh-sach/cs6.png') }}" alt="Fitfood" />
                        <ul>
                            <li>Kh&aacute;ch h&agrave;ng cũng sẽ được tư vấn vi&ecirc;n giải đ&aacute;p những thắc mắc đồng thời c&oacute; thể đặt h&agrave;ng th&ocirc;ng qua inbox trực tiếp tr&ecirc;n fanpage của Fitfood</li>
                            <li>Tư vấn vi&ecirc;n sẽ hỗ trợ điền th&ocirc;ng tin gi&ugrave;m kh&aacute;ch tr&ecirc;n đơn đặt h&agrave;ng v&agrave; hệ thống sẽ tự động gửi 1 email x&aacute;c nhận đợn h&agrave;ng đến cho kh&aacute;ch h&agrave;ng sau khi đơn h&agrave;ng được đặt th&agrave;nh c&ocirc;ng.</li>
                        </ul>
                        <p>&nbsp;</p>
                        <p style="padding-left: 30px;"><strong><u>b) Hướng dẫn đặt h&agrave;ng trực tuyến</u></strong></p>
                        <p><strong>Bước 1: Điền đơn đặt h&agrave;ng</strong></p>
                        <ul>
                            <li>Điền c&aacute;c th&ocirc;ng tin bắt buộc theo y&ecirc;u cầu tại: fitfood.vn/order</li>
                            <li>Xem menu (nếu c&oacute; nhu cầu)</li>
                            <li>Chọn g&oacute;i thức ăn theo nhu cầu + số lượng muốn đặt h&agrave;ng + c&aacute;c y&ecirc;u cầu đặc biệt nếu c&oacute;</li>
                            <li>Nhập m&atilde; khuyến m&atilde;i (nếu c&oacute;) + ghi ch&uacute; về c&aacute;c y&ecirc;u cầu giao h&agrave;ng: gởi bảo vệ, h&acirc;m n&oacute;ng phần ăn&hellip;.</li>
                            <li>Sau khi kiểm tra hết c&aacute;c th&ocirc;ng tin đ&atilde; nhập, vui l&ograve;ng nhấp v&agrave;o n&uacute;t &ldquo; Đặt h&agrave;ng&rdquo;</li>
                        </ul>
                        <img src="{{ asset('assets/images/chinh-sach/cs1.png') }}" alt="Fitfood" />
                        <img src="{{ asset('assets/images/chinh-sach/cs2.png') }}" alt="Fitfood" />
                        <img src="{{ asset('assets/images/chinh-sach/cs3.png') }}" alt="Fitfood" />
                        <img src="{{ asset('assets/images/chinh-sach/cs4.png') }}" alt="Fitfood" />
                        <img src="{{ asset('assets/images/chinh-sach/cs5.png') }}" alt="Fitfood" />
                        <p><strong>Bước 2: Nhận email x&aacute;c nhận</strong><br /> Sau khi đ&atilde; điền đầy đủ th&ocirc;ng tin đặt h&agrave;ng v&agrave; x&aacute;c nhận Đặt H&agrave;ng, một Email x&aacute;c nhận sẽ được tự động gửi từ hệ thống của Fitfood. Bạn vui long kiểm tra Email đ&atilde; đăng k&yacute; tại đơn đặt h&agrave;ng. Nếu bạn c&oacute; nhu cầu thay đổi th&ocirc;ng tin, vui l&ograve;ng gọi 0932 788 120 để nh&acirc;n vi&ecirc;n Fitfood điều chỉnh gi&uacute;p bạn.</p>
                        <p>Khi bạn nhận được email từ Fitfood tức l&agrave; đơn h&agrave;ng của bạn đ&atilde; được ghi nhận tr&ecirc;n hệ thống Fitfood, nh&acirc;n vi&ecirc;n Fitfood sẽ kh&ocirc;ng gọi điện lại để x&aacute;c nhận.</p>
                        <p><strong>Bước 3: Thanh to&aacute;n v&agrave; thường thức</strong></p>
                        <p>Bạn vui l&ograve;ng thanh to&aacute;n trước khi Fitfood giao h&agrave;ng hoặc thanh to&aacute;n trực tiếp cho nh&acirc;n vi&ecirc;n Fitfood sau khi nhận phần ăn. Chi tiết về h&igrave;nh thức thanh to&aacute;n, bạn vui l&ograve;ng tham khảo c&aacute;c quy định về thanh to&aacute;n của Fitfood.</p>
                        <p><strong>&nbsp;</strong></p>
                        <p><strong><u>3. Quy định giao h&agrave;ng v&agrave; bảo quản</u></strong></p>
                        <ul>
                            <li>C&aacute;c phần ăn (2 - 3 bữa/ng&agrave;y) sẽ được giao đến cho kh&aacute;ch v&agrave;o buổi s&aacute;ng c&aacute;c ng&agrave;y trong tuần (từ 8h - 10h t&ugrave;y khu vực) hoặc v&agrave;o buổi tối h&ocirc;m trước đối với c&aacute;c y&ecirc;u cầu giao sớm (y&ecirc;u cầu giao trước 8h s&aacute;ng sẽ được giao từ 7pm - 10pm tối h&ocirc;m trước)</li>
                            <li>C&aacute;c phần ăn của Fitfood đều được cấp đ&ocirc;ng sau khi chế biến nhằm đảm bảo chất lượng phần ăn v&agrave; tr&aacute;nh &ocirc;i thiu trong qu&aacute; tr&igrave;nh vận chuyển.</li>
                            <li>Sau khi nhận phần ăn, bạn vui l&ograve;ng để v&agrave;o ngăn m&aacute;t tủ lạnh v&agrave; n&ecirc;n h&acirc;m lại bằng microwave trong 02 ph&uacute;t trước khi d&ugrave;ng để đảm bảo chất lượng thức ăn tốt nhất. Đối với hủ sốt, kh&aacute;ch c&oacute; thể h&acirc;m c&ugrave;ng với hộp nhựa nhưng vui l&ograve;ng mở nắp ra v&igrave; nhựa nắp trong kh&ocirc;ng d&ugrave;ng được trong l&ograve; vi s&oacute;ng.</li>
                            <li>Đối với c&aacute;c kh&aacute;ch kh&ocirc;ng c&oacute; tủ lạnh hoặc kh&ocirc;ng h&acirc;m n&oacute;ng bằng microwave, Fitfood <strong><u>kh&ocirc;ng</u></strong> đảm bảo được chất lượng thức ăn ở điều kiện tốt nhất. Tuy nhi&ecirc;n bạn c&oacute; thể x&agrave;o hoặc hấp c&aacute;ch thủy v&agrave;o buổi tối để đảm bảo hương vị m&oacute;n ăn.</li>
                        </ul>
                        <p>&nbsp;</p>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop