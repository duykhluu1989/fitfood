<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Fitfood - Weekly meals for a healthy lifestyle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Hello! I am Fitfood. I love food.">
    <meta name="author" content="Fitfood">
    <meta name="application-name" content="Fitfood.vn" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Fitfood.vn" />
    <meta property="og:description" content="Weekly meals for a healthy lifestyle" />
    <meta property="og:url" content="http://fitfood.vn" />
    <meta property="og:site_name" content="Fitfood" />
    <meta property="og:image" content="{{ asset('assets/img/logo.png') }}" />
    <meta property="og:locale" content="vi_VN" />
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <meta name="format-detection" content="telephone=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&amp;subset=latin-ext,vietnamese" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=latin-ext,vietnamese" rel="stylesheet">
    <?php
    echo Minify::stylesheet([
        '/../assets/css/font-awesome.min.css',
        '/../assets/landing/fractionSlider/css/fractionslider.css',
        '/../assets/landing/bootstrap-4/css/bootstrap.min.css',
        '/../assets/landing/slick/slick.css',
        '/../assets/landing/slick/slick-theme.css',
        '/../assets/landing/easyResponsiveTab/css/easy-responsive-tabs.css',
        '/../assets/landing/css/OpenSans.css',
        '/../assets/landing/css/style.css',
    ])->withFullUrl();
    ?>
</head>
<body style="min-height: 2000px;" class="" data-spy="scroll" data-target="#headNav" data-offset="100">
<nav id="headNav" class="navbar navbar-expand-lg navbar-dark" style="background-color: #222425;">
    <a id="brandLogo" class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('assets/landing/img/logo-fitfood.png') }}" />
    </a>
    <a id="registerButton" class="register_button d-lg-none calltoaction" href="#sec5">ĐĂNG KÝ NGAY</a>
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#Navbar_main" aria-controls="Navbar_main" aria-expanded="true" aria-label="Ẩn/hiện thanh menu">
        <span>FITFOOD</span><span class="caret"><img src="{{ asset('assets/landing/img/caret.png') }}" /></span>
    </button>
    <div class="collapse navbar-collapse text-right" id="Navbar_main">
        <ul class="navbar-nav nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#sec1">VỀ FITFOOD <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#sec2">QUY TRÌNH SẢN XUẤT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#sec3">THỰC ĐƠN</a>
            </li>
            <li class="nav-item noboder">
                <a class="nav-link" href="#sec4">KHÁCH HÀNG</a>
            </li>
            <li class="nav-item register_button d-none d-lg-inline-block">
                <a class="nav-link" href="{{ url('order') }}">ĐĂNG KÝ NGAY</a>
            </li>
        </ul>
        <div class="nav-overlay d-lg-none"></div>
    </div>
</nav>
<div class="head-banner" data-enllax-ratio="0.5">
    <img id="head-decor-2" src="{{ asset('assets/landing/img/bg-1.png') }}" data-enllax-ratio="0.1" data-enllax-type="foreground" />
    <div id="head-text" data-enllax-ratio="-0.2" data-enllax-type="foreground">
        <small>BẠN BẬN RỘN?</small><br/>Bạn muốn cải thiện vóc dáng?<br/><small>HÔM NAY ĂN GÌ?</small>
        <a id="head-arrow" href="#sec1"><span>Câu trả lời dành cho bạn</span><br /><img src="{{ asset('assets/landing/img/arrow_down.png') }}" /></a>
    </div>
</div>
<div id="sec1" style="background-color: #EAEAEA; padding-bottom: 50px;">
    <div class="container" >
        <div>&nbsp;</div>
        <div class="intro">
            <h1>Fitfood VN</h1>
            <h5>Nhà cung cấp thực đơn giảm cân sạch giao tận nơi đầu tiên tại Sài Gòn</h5>
            <p>
                Luôn quan niệm một lối sống lành mạnh cần gắn liền với thói quen ăn uống. Fitfood đem đến cho bạn một
                giải pháp toàn diện với các gói thực phẩm đa dạng được thiết kế theo tiêu chí lành mạnh, tốt cho sức khỏe
                và giảm cân một cách khoa học.
            </p>
            <img class="d-none d-md-block" src="{{ asset('assets/landing/img/s2-img4-2.png') }}" />
        </div>
        <div>&nbsp;</div>
        <div id="sec1-slide">
            <div id="sec1-scene1" class="card noborder nobackground">
                <div class="card-img" style="text-align: center;">
                    <img height="120" class="" src="{{ asset('assets/landing/img/s2-img3.png') }}" />

                </div>
                <div class="card-body">
                    <h5 class="card-title">Tiết kiệm thời gian<br />dịch vụ tiện lợi</h5>
                    <ul class="check-list">
                        <li>Chỉ cần 3 phút order</li>
                        <li>Đặt 1 lần cho 1 tuần</li>
                        <li>Phần ăn giao tận nơi mỗi ngày</li>
                        <li>Không cần đi chợ, nấu nướng...</li>
                    </ul>
                </div>
            </div>
            <div id="sec1-scene2" class="card noborder nobackground">
                <div class="card-img" style="text-align: center;">
                    <img height="120" class="" src="{{ asset('assets/landing/img/s2-img2.png') }}" />
                </div>
                <div class="card-body">
                    <h5 class="card-title">Thực phẩm an toàn<br />nguồn gốc rõ ràng</h5>
                    <ul class="check-list">
                        <li>Rau Vietgap nhập từ VinEco và Đà Lạt</li>
                        <li>Thịt từ các trang trại uy tín, được kiểm nghiệm</li>
                        <li>Thực phẩm đông lạnh từ Mega Market</li>
                        <li>Nói KHÔNG với thực phẩm không xuất xứ</li>
                    </ul>
                </div>
            </div>
            <div id="sec1-scene3" class="card noborder nobackground">
                <div class="card-img" style="text-align: center;">
                    <img height="120" class="" src="{{ asset('assets/landing/img/s2-img1.png') }}" />
                </div>
                <div class="card-body">
                    <h5 class="card-title">Thực đơn đa dạng<br />giảm cân khoa học</h5>
                    <ul class="check-list">
                        <li>Cam kết KHÔNG bột ngọt</li>
                        <li>Ít đường, hạn chế tối đa chất béo</li>
                        <li>Không sử dụng tinh bột trắng</li>
                        <li>Hơn 100+ món Âu, Á thay đổi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="sec2" style="background-color: #fff;">
    <div style="margin-bottom: 50px;">&nbsp;</div>
    <div class="container">
        <img class="d-none d-lg-block" src="{{ asset('assets/landing/img/bg-2.png') }}" style="position: absolute; right: 0px; top: -30px;" />

        <h3 style="text-align: center;">QUY TRÌNH SẢN XUẤT HIỆN ĐẠI CHUYÊN NGHIỆP</h3>
        <h1 style="text-align: center;">ĐẠT TIÊU CHUẨN VSATTP</h1>
        <div style="margin-bottom: 50px;">&nbsp;</div>
        <div id="sec21" class="card noborder horizontal style1 nobackground">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-img-top" >
                        <img src="{{ asset('assets/landing/img/s3-img-1.png') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h1><i>1</i></h1>
                        <h3>Lựa chọn thực phẩm từ nguồn cung cấp uy tín</h3>
                        <p>
                            Các đầu bếp của Fitfood đã đưa ra tiêu chuẩn khắt khe trong khâu lựa chọn thực phẩm, nhằm đảm bảo chất lượng đầu vào của món ăn. 100% sản phẩm
                            được Fitfood tin dùng đều đến từ các nhà cung cấp uy tín hàng đầu, đã được chứng nhận và kiểm nghiệm đầy đủ.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div id="sec22" class="curve-arrow">
            <img class="d-none d-md-inline" src="{{ asset('assets/landing/img/s3-arrow-1.png') }}" style="margin-top: -40px;"/>
        </div>
        <div id="sec23" class="card noborder horizontal style2 nobackground">
            <div class="row">
                <div class="col-md-6 d-md-none d-lg-none d-xl-none">
                    <div class="card-img-top">
                        <img src="{{ asset('assets/landing/img/s3-img2.png') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h1><i>2</i></h1>
                        <h3>Chế biến tại bếp công nghiệp hiện đại</h3>
                        <p>
                            Fitfood luôn chú trọng đầu tư cho máy móc, thiết bị hiện đại để thực phẩm được chế biến trong điều kiện tốt nhất,
                            giữ nguyên được độ tươi ngon, dưỡng chất cùng hương vị của các nguyên liệu. Các món ăn đuoặc nấu mỗi ngày dưới sự giám sát
                            của bếp trưởng 5 sao chuyên nghiệp.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block">
                    <div class="card-img-top">
                        <img src="{{ asset('assets/landing/img/s3-img2.png') }}" />
                    </div>
                </div>
            </div>
        </div>
        <div id="sec24" class="curve-arrow">
            <img class="d-none d-md-inline" src="{{ asset('assets/landing/img/s3-arrow-2.png') }}" style="margin-top: -0px; margin-bottom: 20px;" />
        </div>
        <div id="sec25" class="card noborder horizontal style1 nobackground">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-img-top">
                        <img src="{{ asset('assets/landing/img/s3-img4.png') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h1><i>3</i></h1>
                        <h3>Bảo quản thành phẩm trong phòng lạnh ngừa khuẩn</h3>
                        <p>
                            Món ăn sau khi chế biến sẽ được đóng gói trong hộp nhựa mới được thiết kế riêng, an toàn khi hâm nóng trong lò vi sóng.
                            Sau đó thành phẩm sẽ được đưa vào cấp đông trong vòng 30 phút kể từ khi hoàn tất. Toàn bộ quy trình trên diễn ra trong
                            môi trường được khử trùng nhằm đảm bảo vệ sinh cao nhất.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-bottom: 50px;">&nbsp;</div>
    </div>
</div>
<div id="sec3" style="background-image: url('{{ asset('assets/landing/img/s4-bg.png') }}'); background-size: 100% auto; padding-top: 50px; padding-bottom: 50px;" data-enllax-ratio="0.2" data-enllax-type="background">
    <h1 style="text-align: center; color: #fff;">Fitfood</h1>
    <h5 style="text-align: center; color: #fff;">Thương hiệu Heathy Food được tin dùng nhất tại Sài Gòn</h5>
    <div id="hightlights-recipes">
        <div>
            <img src="{{ asset('assets/landing/img/food-1.png') }}" />
            <h4>TRỨNG CUỘN CHẢ CÁ</h4>
            <h5>Calories: 479 Kcal</h5>
        </div>
        <div>
            <img src="{{ asset('assets/landing/img/food-2.png') }}" />
            <h4>SALAD TÔM CAESAR</h4>
            <h5>Calories: 472 Kcal</h5>
        </div>
        <div>
            <img src="{{ asset('assets/landing/img/food3.png') }}" />
            <h4>SALAD PASTA PHÚC BỒN TỬ</h4>
            <h5>Calories: 483 Kcal</h5>
        </div>
        <div>
            <img src="{{ asset('assets/landing/img/food-4.png') }}" />
            <h4>CỐT LẾT SỐT TIÊU + KHOAI NGHIỀN</h4>
            <h5>Calories: 595 Kcal</h5>
        </div>
        <div>
            <img src="{{ asset('assets/landing/img/food 5.png') }}" />
            <h4>SALAD GÀ HONG KONG</h4>
            <h5>Calories: 458 Kcal</h5>
        </div>
    </div>
</div>
<div id="sec4" style="background-image: url('{{ asset('assets/landing/img/s5-bg.png') }}'); background-size: 100% auto;">
    <div class="container">
        <div style="margin-bottom: 50px;">&nbsp;</div>
        <div id="tabs1">
            <ul class="resp-tabs-list tabs1">
                <li class="resp-tab-active">Người nổi tiếng tin dùng</li>
                <li>Thương hiệu chọn chúng tôi</li>
                <li>Cung cấp sự kiến lớn</li>
            </ul>

            <div class="resp-tabs-container tabs1">
                <div class="resp-tab-content-active">
                    <div id="famous-people">
                        <div>
                            <img id="sec41" src="{{ asset('assets/landing/img/s5-img-1.png') }}" />
                        </div>
                        <div>
                            <img id="sec42"  src="{{ asset('assets/landing/img/s5-img-2.png') }}" />
                        </div>
                        <div>
                            <img id="sec43"  src="{{ asset('assets/landing/img/s5-img-3.png') }}" />
                        </div>
                    </div>
                    <div id="famous-overlay" class="tab-overlay"></div>
                </div>
                <div class="">
                    <img src="{{ asset('assets/landing/img/s5-brand.png') }}" />
                </div>
                <div class="">
                    <img src="{{ asset('assets/landing/img/s5-event.png') }}" />
                </div>
            </div>
        </div>
        <div class="d-lg-none" style="padding-bottom: 30px;">&nbsp;</div>
    </div>
</div>
<div id="sec5" style="background-color: #EAEAEA; border-bottom: 2px dashed #808080;">
    <div class="container">
        <div style="padding-bottom: 30px;">&nbsp;</div>
        <div id="subscribe">
            <div class="brace-left"></div>
            <div class="brace-right"></div>
            <h6><i>Chỉ với 3 phút đăng ký, lấy lại vóc dáng chuẩn</i></h6>
            <a class="calltoaction" href="{{ url('order') }}">Đăng ký ngay</a>
            <div class="clearfix"></div>
        </div>
        <div style="padding-bottom: 30px;">&nbsp;</div>
    </div>
</div>
<div style="background-color: #EAEAEA;" >
    <div class="container">
        <div id="sec6">
            <div class="card noborder nobackground">
                <div class="card-body">
                    <div class="card-title">
                        <img style="padding: 20px;" src="{{ asset('assets/landing/img/check-icon-big.png') }}" />
                        <h5>Tiện lợi hợp nhu cầu</h5>
                    </div>
                    <ul class="dash">
                        <li>
                            Tùy chọn gói linh hoạt
                        </li>
                        <li>
                            Chủ động thời gian order
                        </li>
                        <li>
                            Thanh toán đa dạng
                        </li>
                        <li>
                            Giao hàng tận nơi
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card noborder nobackground">
                <div class="card-body">
                    <div class="card-title">
                        <img style="padding: 20px;" src="{{ asset('assets/landing/img/check-icon-big.png') }}" />

                        <h5>Sản phẩm dùng kèm đa dạng</h5>

                    </div>
                    <ul class="dash">
                        <li>
                            Hạt ăn vặt không tăng cân
                        </li>
                        <li>
                            Nước ép trái cây 100% hữu cơ
                        </li>
                        <li>
                            Sữa hạt 100% nguyên chất
                        </li>
                        <li>
                            Bánh cookie tốt cho sức khỏe
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card noborder nobackground">
                <div class="card-body">
                    <div class="card-title">
                        <img style="padding: 20px;" src="{{ asset('assets/landing/img/check-icon-big.png') }}" />

                        <h5>Hiệu quả trong ngoài rõ rệt</h5>

                    </div>
                    <ul class="dash">
                        <li>
                            Săn chắc bụng sau 1 tuần
                        </li>
                        <li>
                            Da mịn màng, hết mụn
                        </li>
                        <li>
                            Cơ thể hạn chế tích nước
                        </li>
                        <li>
                            Giảm đường huyết & cholesterol
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="d-md-none" style="padding-bottom: 30px;">&nbsp;</div>
    </div>
</div>
<footer id="footer">
    <h6><i>Bạn vẫn còn phân vân và cần tư vấn thêm?<br/>Liên hệ với chúng tôi qua hotline</i></h6>
    <h2 class="hotline">(+84) 932 788 120<br/>(+84) 938 074 120</h2>
    <h6><i>Hoặc để lại thông tin trên Fanpage, Fitfood sẽ liên hệ với bạn trong ít phút</i></h6>
    <br/>
    <a href="https://www.facebook.com/fitfoodvietnam">
        <img style="width: 3em; margin-right: 1em;" src="{{ asset('assets/landing/img/Facebook-color.svg') }}" />
    </a>
    <a href="https://www.instagram.com/fitfoodvn">
        <img style="width: 3em;" src="{{ asset('assets/landing/img/Instagram-color.svg') }}" />
    </a>
</footer>
<div id="online-support" class="hidden-xs">
    <div id="online-support-header">
        <span id="online-support-title">
            <i class="fa fa-comment" aria-hidden="true"></i>
            @lang('home_page.onlineSupport')
        </span>
        <i id="online-support-hide" class="fa fa-times pull-right" aria-hidden="true"<?php echo (isset($_COOKIE[App\Libraries\Util::COOKIE_HIDE_ONLINE_SUPPORT_WINDOW_NAME]) ? ' style="display: none"' : ''); ?>></i>
    </div>
    <div id="online-support-body"<?php echo (isset($_COOKIE[App\Libraries\Util::COOKIE_HIDE_ONLINE_SUPPORT_WINDOW_NAME]) ? ' style="display: none"' : ''); ?>>
        <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffitfoodvietnam&tabs=messages&width=340&height=300&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1499077570417040" width="340px" height="300px" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
    </div>
</div>
<?php
echo Minify::javascript([
    '/../assets/landing/js/jquery-3.2.1.min.js',
    '/../assets/landing/js/jquery-migrate-1.4.1.min.js',
    '/../assets/landing/js/detectmobilebrowser.js',
    '/../assets/landing/scrollMagic/GSAP/jquery.gsap.min.js',
    '/../assets/landing/scrollMagic/GSAP/TweenLite.min.js',
    '/../assets/landing/scrollMagic/GSAP/TweenMax.min.js',
    '/../assets/landing/scrollMagic/GSAP/TimelineLite.min.js',
    '/../assets/landing/scrollMagic/GSAP/TimelineMax.min.js',
    '/../assets/landing/scrollMagic/velocity.min.js',
    '/../assets/landing/scrollMagic/ScrollMagic.min.js',
    '/../assets/landing/scrollMagic/plugins/jquery.ScrollMagic.min.js',
    '/../assets/landing/scrollMagic/plugins/animation.gsap.min.js',
    '/../assets/landing/scrollMagic/plugins/animation.velocity.min.js',
    '/../assets/landing/scrollMagic/plugins/debug.addIndicators.min.js',
    '/../assets/landing/js/jquery.enllax.min.js',
    '/../assets/landing/fractionSlider/jquery.fractionslider.min.js',
    '/../assets/landing/bootstrap-4/js/bootstrap.bundle.min.js',
    '/../assets/landing/slick/slick.min.js',
    '/../assets/landing/easyResponsiveTab/js/easyResponsiveTabs.js',
    '/../assets/landing/js/main.js',
])->withFullUrl();
?>
</body>
</html>