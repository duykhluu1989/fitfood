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

                        <p>1. M&ocirc; h&igrave;nh hoạt động v&agrave; c&aacute;c g&oacute;i thức ăn:</p>
                        <ul>
                            <li>M&ocirc; h&igrave;nh hoạt động</li>
                        </ul>
                        <p>Fitfood chuy&ecirc;n cung cấp c&aacute;c bữa ăn sạch h&agrave;ng tuần được chuẩn bị sẵn, gi&uacute;p bạn theo đuổi một phong c&aacute;ch sống khỏe v&agrave; c&acirc;n bằng dinh dưỡng.</p>
                        <p>Fitfood chỉ nhận order cho nguy&ecirc;n tuần (5 ng&agrave;y từ thứ 2 đến thứ 6), v&agrave; hiện tại Fitfood chưa nhận order lẻ từng ng&agrave;y hoặc từng bữa.</p>
                        <p>Tất cả c&aacute;c bữa ăn đều được cấp đ&ocirc;ng nhằm đảm bảo an to&agrave;n thực phẩm trong qu&aacute; tr&igrave;nh vận chuyển. Bạn vui l&ograve;ng bảo quản trong tủ lạnh v&agrave; h&acirc;m n&oacute;ng trước khi ăn.</p>
                        <p>Lưu &yacute;: Để đảm bảo chất lượng phục vụ với quy m&ocirc; nhỏ của bếp, Fitfood sẽ ngưng nhận c&aacute;c đơn h&agrave;ng mới từ thứ 7 tuần trước. C&aacute;c đơn h&agrave;ng sau thời gian n&agrave;y sẽ được dời sang tuần sau, mong bạn th&ocirc;ng cảm !</p>
                        <ul>
                            <li>C&aacute;c g&oacute;i thức ăn</li>
                        </ul>
                        <p>Hiện tại Fitfood cung cấp c&aacute;c g&oacute;i sau:</p>
                        <p>1/ G&oacute;i FULL (3 bữa/ng&agrave;y) - 700k/tuần</p>
                        <p>2/ G&oacute;i FIT (2 bữa/ng&agrave;y, trưa &amp; tối, s&aacute;ng &amp; trưa, hoặc s&aacute;ng &amp; tối) - 550k/tuần</p>
                        <p>3/ G&oacute;i MEAT LOVER (Gấp đ&ocirc;i lượng protein, 2 bữa trưa - tối bao gồm tinh bột phức trong c&aacute;c buổi trưa) - 900k/tuần</p>
                        <p>4/ G&oacute;i VEG (2 bữa/ng&agrave;y, trưa v&agrave; tối) &ndash; 550k/tuần</p>
                        <p>Dịch vụ k&egrave;m với 4 g&oacute;i thức ăn tr&ecirc;n:</p>
                        <p>1/ Y&ecirc;u cần đăc biệt ( d&agrave;nh cho kh&aacute;ch dị ứng với thức ăn c&aacute;c loại thịt, c&aacute;): ph&iacute; 50k/tuần</p>
                        <p>2/ Đổi bữa linh hoạt: d&agrave;nh cho kh&aacute;ch muốn ăn linh hoạt theo từng ng&agrave;y: Thứ ăn đặt trưa &ndash; tối, thứ 3 ăn s&aacute;ng &ndash; trưa&hellip;..</p>
                        <p>3/ Th&ecirc;m phần ăn s&aacute;ng cho g&oacute;i MEAT: g&oacute;i MEAT chỉ c&oacute; 2 bữa/ ng&agrave;y, trưa &ndash; tối n&ecirc;n kh&aacute;ch muốn ăn th&ecirc;m phần ăn s&aacute;ng th&igrave; sẽ t&iacute;nh th&ecirc;m l&agrave; 200k/tuần</p>
                        <p>Sản phẩm phụ <strong>(chỉ b&aacute;n k&egrave;m với g&oacute;i thức ăn)</strong>:</p>
                        <p>1/ Nước tr&aacute;i c&acirc;y ( giao 3 ng&agrave;y/ tuần , thứ 2 &ndash; thứ 4, thứ 6) &ndash; 150k/ tuần</p>
                        <p>2/ Sữa từ hạt ( giao 5 ng&agrave;y/ tuần, từ thứ 2 đến thứ 6) &ndash; 150k/ tuần</p>
                        <p>3/ Hạt dinh dưỡng: 149k/sản phẩm</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>2. Quy định về đặt h&agrave;ng</p>
                        <p>Fitfood chỉ nhận order theo tuần, kh&ocirc;ng nhận lẻ 1 bữa/ tuần hay 1 ng&agrave;y</p>
                        <p>Fitfood chốt đơn đặt h&agrave;ng 12 giờ tối thứ 7 v&agrave; bắt đầu giao từ thứ 2 h&agrave;ng tuần</p>
                        <p>Ch&uacute; &yacute;: đối với những ng&agrave;y lễ rơi v&agrave;o 1 trong c&aacute;c ng&agrave;y từ thứ 2 đến thứ 6, Fitfoot sẽ trừ tiền phần ăn v&agrave;o những ng&agrave;y nghỉ lễ.</p>
                        <ul>
                            <li>Hướng dẫn đặt h&agrave;ng</li>
                        </ul>
                        <ul>
                            <li><strong>C&aacute;ch đặt h&agrave;ng</strong>: theo 3 c&aacute;ch</li>
                        </ul>
                        <p><strong>C&aacute;ch 1</strong>: Bạn vui l&ograve;ng điền đầy đủ th&ocirc;ng tin đặt h&agrave;ng qua website: fitfood.vn/order, một email x&aacute;c nhận sẽ được tự động gửi v&agrave;o email bạn đăng k&yacute;.</p>
                        <p><strong>C&aacute;ch 2</strong>: Nhận tư vấn th&ocirc;ng qua điện thoại 0932 788 120 - 0971 248 950</p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>C&aacute;ch 3</strong>: Nhận tư vấn qua Inbox Fanpage : facebook.com/fitfoodvietnam</p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;Ch&uacute; &yacute;: Kh&ocirc;ng b&aacute;n trực tiếp tại c&ocirc;ng ty</p>
                        <ul>
                            <li><strong>Điền đầy đủ th&ocirc;ng tin tr&ecirc;n trang: fitfood.vn/order</strong></li>
                        </ul>
                        <p>Bước 1: Điền đơn đặt h&agrave;ng</p>
                        <p>+ Điền c&aacute;c th&ocirc;ng tin bắt buộc theo y&ecirc;u cầu</p>
                        <p>+ Xem menu (nếu c&oacute; nhu cầu)</p>
                        <p>+ Chọn g&oacute;i thức ăn theo nhu cầu &nbsp;+ số lượng muốn đặt h&agrave;ng (c&oacute; c&aacute;c sản phẩm add-on k&egrave;m theo: nước tr&aacute;i c&acirc;y, sữa từ hạt, hạt dinh dưỡng) + c&aacute;c y&ecirc;u cầu đặt biệt nếu c&oacute;</p>
                        <p>+ Nhập m&atilde; khuyến m&atilde;i (nếu c&oacute;) + c&aacute;c ghi ch&uacute; về giao h&agrave;ng: gởi bảo vệ, h&acirc;m n&oacute;ng phần ăn&hellip;.</p>
                        <p>+ Nhấp v&agrave;o n&uacute;t &ldquo; Đặt h&agrave;ng&rdquo;</p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ch&uacute; &yacute; : &ldquo;&gt;&rdquo; l&agrave; tăng số lượng muốn đặt h&agrave;ng</p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ldquo;&lt;&rdquo; l&agrave; giảm số lượng muốn đặt h&agrave;ng</p>
                        <p>Bước 2: Nhận email x&aacute;c nhận<br />Ch&uacute; &yacute;: Email x&aacute;c nhận tức hệ thống đ&atilde; ghi nhận, Fitfood kh&ocirc;ng gọi điện lại để x&aacute;c nhận</p>
                        <p>Bước 3: Thanh to&aacute;n v&agrave; thường thức</p>
                        <p><strong>Tham khảo h&igrave;nh ảnh minh họa hướng dẫn b&ecirc;n dưới:</strong></p>
                        <p>&nbsp;</p>
                        <img src="{{ asset('assets/images/chinh-sach/cs1.png') }}" alt="Fitfood" />
                        <p>&nbsp;</p>
                        <img src="{{ asset('assets/images/chinh-sach/cs2.png') }}" alt="Fitfood" />
                        <p>&nbsp;</p>
                        <img src="{{ asset('assets/images/chinh-sach/cs3.png') }}" alt="Fitfood" />
                        <p>&nbsp;</p>
                        <img src="{{ asset('assets/images/chinh-sach/cs4.png') }}" alt="Fitfood" />
                        <p>&nbsp;</p>
                        <img src="{{ asset('assets/images/chinh-sach/cs5.png') }}" alt="Fitfood" />
                        <ul>
                            <li><strong>Nhận tư vấn th&ocirc;ng qua điện thoại: 0932-788-120 v&agrave; 0971- 248-950</strong></li>
                        </ul>
                        <p>Tư vấn vi&ecirc;n sẽ trả lời c&aacute;c yều cầu của kh&aacute;ch h&agrave;ng đồng thời sẽ ghi nhận lại th&ocirc;ng tin của kh&aacute;ch h&agrave;ng nếu kh&aacute;ch h&agrave;ng muốn đặt h&agrave;ng th&ocirc;ng qua điện thoại.</p>
                        <p>Tư vấn vi&ecirc;n sẽ điền th&ocirc;ng tin của kh&aacute;ch tr&ecirc;n order form v&agrave; cũng sẽ c&oacute; mail x&aacute;c nhận gởi cho kh&aacute;ch khi đặt h&agrave;ng th&agrave;nh c&ocirc;ng</p>
                        <ul>
                            <li><strong>Nhận tư vấn Inbox tr&ecirc;n fanpage: https://www.facebook.com/fitfoodvietnam/</strong></li>
                        </ul>
                        <p>&nbsp;</p>
                        <img src="{{ asset('assets/images/chinh-sach/cs6.png') }}" alt="Fitfood" />
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kh&aacute;ch h&agrave;ng cũng sẽ được tư vấn vi&ecirc;n giải đ&aacute;p những thắc mắc đồng thời c&oacute; thể đặt h&agrave;ng th&ocirc;ng qua inbox tr&ecirc;n fanpage</p>
                        <p>Tư vấn vi&ecirc;n sẽ điền th&ocirc;ng tin của kh&aacute;ch tr&ecirc;n order form v&agrave; cũng sẽ c&oacute; mail x&aacute;c nhận gởi cho kh&aacute;ch khi đặt h&agrave;ng th&agrave;nh c&ocirc;ng</p>
                        <p>3. Ch&iacute;nh s&aacute;ch vận chuyển v&agrave; ph&iacute; giao h&agrave;ng</p>
                        <ul>
                            <li>Ch&iacute;nh s&aacute;ch vận chuyển: giới hạn 1 số quận của TP HCM được đăng tr&ecirc;n web site v&agrave; c&oacute; c&aacute;c khung giờ nhất định cho từng quận</li>
                            <li>Ph&iacute; giao h&agrave;ng: T&ugrave;y v&agrave;o địa chỉ giao h&agrave;ng của kh&aacute;ch v&agrave; chọn quận m&agrave; ph&iacute; giao h&agrave;ng miễn ph&iacute; hay được t&iacute;nh</li>
                        </ul>
                        <p>Ch&uacute; &yacute;: &nbsp;&nbsp;Ph&iacute; giao h&agrave;ng = ng&agrave;y thực tế ăn x ph&iacute; giao h&agrave;ng tr&ecirc;n 1 ng&agrave;y</p>
                        <p>&nbsp;</p>
                        <table>
                            <tbody>
                            <tr>
                                <td width="147">
                                    <p><strong>Khu vực giao h&agrave;ng</strong></p>
                                </td>
                                <td width="150">
                                    <p><strong>&nbsp;Ph&iacute; ship tr&ecirc;n 1 tuần </strong></p>
                                </td>
                                <td width="301">
                                    <p><strong>Khung thời gian giao h&agrave;ng</strong></p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>Quận 1</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;Miễn ph&iacute;</p>
                                </td>
                                <td width="301">
                                    <p>8:00 - 8:30<br />8:30 - 9:00<br />9:00 - 9:30<br />9:30 - 10:00<br />10:00 - 10:30<br />10:30 - 11:00<br />Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>Quận 2: Chỉ khu vực Thảo Điền v&agrave; Mai Ch&iacute; Thọ</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;75,000</p>
                                </td>
                                <td width="301">
                                    <p>9:00 - 9:30<br />9:30 - 10:00<br />10:00 - 10:30<br />Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>Quận 3</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;Miễn ph&iacute;</p>
                                </td>
                                <td width="301">
                                    <p>8:00 - 8:30<br />8:30 - 9:00<br />9:00 - 9:30<br />9:30 - 10:00<br />10:00 - 10:30<br />10:30 - 11:00<br />Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>Quận 4</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;Miễn ph&iacute;</p>
                                </td>
                                <td width="301">
                                    <p>8:00 - 8:30<br />8:30 - 9:00<br />10:30 - 11:00<br />Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>Quận 5</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;50,000</p>
                                </td>
                                <td width="301">
                                    <p>8:00 - 8:30<br />8:30 - 9:00<br />9:00 - 9:30<br />9:30 - 10:00<br />10:00 - 10:30<br />10:30 - 11:00<br />Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>Quận 6</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;75,000</p>
                                </td>
                                <td width="301">
                                    <p>8:30 - 9:00<br />9:00 - 9:30<br />9:30 - 10:00<br />10:00 - 10:30<br />10:30 - 11:00<br />Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>Quận 7</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;50,000</p>
                                </td>
                                <td width="301">
                                    <p>8:00 - 8:30<br />8:30 - 9:00<br />9:00 - 9:30<br />9:30 - 10:00<br />10:00 - 10:30<br />10:30 - 11:00<br />Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>Quận 8</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;75,000</p>
                                </td>
                                <td width="301">
                                    <p>8:00 - 8:30<br />10:30 - 11:00<br />Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>Quận 10</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;50,000</p>
                                </td>
                                <td width="301">
                                    <p>8:00 - 8:30<br />8:30 - 9:00<br />9:00 - 9:30<br />9:30 - 10:00<br />10:00 - 10:30<br />10:30 - 11:00<br />Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>Quận 11</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;50,000</p>
                                </td>
                                <td width="301">
                                    <p>8:00 - 8:30<br />8:30 - 9:00<br />9:00 - 9:30<br />9:30 - 10:00<br />10:00 - 10:30<br />10:30 - 11:00<br />Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>Ph&uacute; Nhuận</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;50,000</p>
                                </td>
                                <td width="301">
                                    <p>8:30 - 9:00<br />9:00 - 9:30<br />9:30 - 10:00<br />10:00 - 10:30<br />10:30 - 11:00<br />Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>B&igrave;nh Thạnh</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;50,000</p>
                                </td>
                                <td width="301">
                                    <p>8:30 - 9:00<br />9:00 - 9:30<br />9:30 - 10:00<br />10:00 - 10:30<br />10:30 - 11:00<br />Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>T&acirc;n B&igrave;nh</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;75,000</p>
                                </td>
                                <td width="301">
                                    <p>8:30 - 9:00<br />9:00 - 9:30<br />9:30 - 10:00<br />10:00 - 10:30<br />10:30 - 11:00<br />Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>T&acirc;n Ph&uacute;</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;75,000</p>
                                </td>
                                <td width="301">
                                    <p>8:30 - 9:00<br />9:00 - 9:30<br />9:30 - 10:00<br />10:00 - 10:30<br />10:30 - 11:00<br />Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="147">
                                    <p>G&ograve; Vấp</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;75,000</p>
                                </td>
                                <td width="301">
                                    <p>Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p>4. Những lưu &yacute; khi sử dụng dịch vụ về thời gian giao h&agrave;ng, bảo quản, hướng dẫn trước khi sử dụng</p>
                        <p>-C&aacute;c phần ăn (2 - 3 bữa/ng&agrave;y) sẽ được giao đến cho kh&aacute;ch v&agrave;o buổi s&aacute;ng c&aacute;c ng&agrave;y trong tuần (từ 8h - 10h t&ugrave;y khu vực) hoặc v&agrave;o buổi tối h&ocirc;m trước đối với c&aacute;c y&ecirc;u cầu giao sớm (y&ecirc;u cầu giao trước 8h s&aacute;ng sẽ được giao từ 7pm - 10pm tối h&ocirc;m trước)</p>
                        <p>- C&aacute;c phần ăn của Fitfood đều được cấp đ&ocirc;ng sau khi chế biến nhằm đảm bảo chất lượng v&agrave; tr&aacute;nh &ocirc;i thiu trong qu&aacute; tr&igrave;nh vận chuyển.</p>
                        <p>- Sau khi nhận phần ăn, kh&aacute;ch vui l&ograve;ng để v&agrave;o ngăn m&aacute;t tủ lạnh v&agrave; h&acirc;m lại bằng microwave trong 02 ph&uacute;t trước khi d&ugrave;ng để đảm bảo chất lượng thức ăn tốt nhất. Đối với hủ sốt, kh&aacute;ch c&oacute; thể h&acirc;m c&ugrave;ng với hộp nhựa nhưng vui l&ograve;ng mở nắp ra v&igrave; nhựa nắp trong kh&ocirc;ng d&ugrave;ng được trong microwave.</p>
                        <p>- Đối với c&aacute;c kh&aacute;ch kh&ocirc;ng c&oacute; tủ lạnh hoặc kh&ocirc;ng h&acirc;m n&oacute;ng bằng microwave, Fitfood kh&ocirc;ng đảm bảo chất lượng thức ăn tốt nhất. C&aacute;c kh&aacute;ch c&oacute; thể x&agrave;o hoặc hấp c&aacute;ch thủy v&agrave;o buổi tối để đảm bảo chất lượng m&oacute;n ăn.</p>
                        <p>5. Quy định về hủy h&agrave;ng v&agrave; ho&agrave;n trả tiền</p>
                        <p>- Fitfood sẽ hủy đơn h&agrave;ng v&agrave;o c&aacute;c ng&agrave;y c&ograve;n lại của kh&aacute;ch với những nguy&ecirc;n nh&acirc;n:</p>
                        <p>+ Ăn kh&ocirc;ng hợp khẩu vị</p>
                        <p>+ Bận việc đi c&ocirc;ng t&aacute;c</p>
                        <ul>
                            <li>Thời gian hủy: trước 12h trưa ng&agrave;y h&ocirc;m trước</li>
                            <li>Ho&agrave;n lại tiền:</li>
                        </ul>
                        <p>+ COD: người giao h&agrave;ng sẽ trả lai tiền v&agrave;o ng&agrave;y h&ocirc;m sau, sau khi nhận được th&ocirc;ng tin hủy h&agrave;ng của kh&aacute;ch</p>
                        <p>+ Chuyển khoản: Fitfood sẽ xin th&ocirc;ng tin v&agrave; chuyển khoản trả lại tiền cho kh&aacute;ch h&agrave;ng</p>
                        <p>6. H&igrave;nh thức thanh to&aacute;n:&nbsp;c&oacute; 3 h&igrave;nh thức thanh to&aacute;n</p>
                        <ul>
                            <li>COD: thanh to&aacute;n tiền mặt v&agrave;o c&aacute;c ng&agrave;y trong tuần khi giao thức ăn</li>
                            <li>MPOS: li&ecirc;n kết với Payoo quẹt thẻ</li>
                            <li>Chuyển khoản: ng&acirc;n h&agrave;ng Vietcombank hay &Aacute; ch&acirc;u &ndash; nếu kh&aacute;ch chọn chuyển khoản th&igrave; số t&agrave;i khoản sẽ được gởi v&agrave;o mail x&aacute;c nhận của kh&aacute;ch</li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop