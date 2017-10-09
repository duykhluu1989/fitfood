<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <title>Fitfood - Weekly meals for a healthy lifestyle</title>
    <link href='https://fonts.googleapis.com/css?family=Delius' rel='stylesheet' type='text/css'>
    <?php
    echo Minify::stylesheet([
        '/../assets/css/bootstrap.min.css',
        '/../assets/css/font-awesome.min.css',
        '/../assets/css/jquery-ui.min.css',
        '/../assets/css/magnific-popup.css',
        '/../assets/css/sweetalert.css',
        '/../assets/css/fonts.css',
        '/../assets/css/style.css',
    ])->withFullUrl();
    ?>
</head>
<body>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-75679054-1', 'auto');
    ga('require', 'displayfeatures');
    ga('send', 'pageview');
</script>
@yield('content')
<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 940209987;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/940209987/?guid=ON&amp;script=0"/>
    </div>
</noscript>
<div class="footer-widget">
    <div class="container">
        <div class="block hotline text-center">
            <i class="fa fa-mobile" aria-hidden="true"></i>
            <p>(+84) 932 788 120 <br />(+84) 938 074 120</p>
        </div>
        <div class="block logo text-center">
            <img src="{{ asset('assets/images/logo-ver.png') }}" alt="Fitfood" border="0" />
        </div>
        <div class="block social text-center">
            <a href="https://www.facebook.com/fitfoodvietnam" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="https://www.instagram.com/fitfoodvn" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            <a href="https://m.me/fitfoodvietnam" target="_blank"><i class="fa fa-comment" aria-hidden="true"></i></a>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <ul style="list-style-type: none">
                    <li style="margin-top: 20px">
                        <a style="color: white" href="{{ url('chinh-sach') }}">* Chính Sách & Quy Định Chung</a>
                    </li>
                    <li style="margin-top: 20px">
                        <a style="color: white" href="{{ url('bao-mat') }}">* Chính Sách Bảo Mật Thông Tin</a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-6">
                <h5 style="color: white">Công ty trách nhiệm hữu hạn Fitfood</h5>
                <p style="color: white">Người đại diện: Thái Quốc Kim</p>
                <p style="color: white">Số CMND: 024113138</p>
                <p style="color: white">Ngày cấp: 07/03/2006 Nơi cấp: CA TP HCM</p>
                <p style="color: white">Địa chỉ: 33 Đường số 14, Khu dân cư Bình Hưng, Ấp 2 – xã Bình Hưng – huyện Bình Chánh – TP HCM – VN</p>
                <p style="color: white">Điện thoại: (+84) 932 788 120 - (+84) 938 074 120</p>
                <p style="color: white">Email: info@fitfood.vn</p>
                <p style="color: white">Số chứng nhận đăng kí kinh doanh của doanh nghiệp: 0313272749</p>
                <p style="color: white">Ngày cấp: 26/05/2015 Nơi cấp: TP HCM</p>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="container">
        <p>Copyright © Fitfood.vn 2016</p>
    </div>
</div>
<a id="back-to-top" href="javascript:void(0)" class="back-to-top" data-placement="top">
    <i class="fa fa-angle-up" aria-hidden="true"></i>
</a>
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
    '/../assets/js/jquery-2.2.4.min.js',
    '/../assets/js/jquery-ui.min.js',
    '/../assets/js/bootstrap.min.js',
    '/../assets/js/sweetalert.min.js',
    '/../assets/js/magnific-popup.min.js',
    '/../assets/js/fitfood.js',
    '/../assets/js/main.js',
])->withFullUrl();
?>
@yield('script')
<?php
if(request()->hasCookie(App\Libraries\Util::COOKIE_SEE_BANNER_NAME) == false)
{
    if(request()->hasCookie(App\Libraries\Util::COOKIE_PLACE_ORDER_CUSTOMER_NAME))
        $banner = App\Models\Banner::getCustomerBanner(request(), App\Libraries\Util::BANNER_CUSTOMER_TYPE_OLD);
    else
        $banner = App\Models\Banner::getCustomerBanner(request(), App\Libraries\Util::BANNER_CUSTOMER_TYPE_NEW);

    if(!empty($banner))
    {
        Cookie::queue(App\Libraries\Util::COOKIE_SEE_BANNER_NAME, true, App\Libraries\Util::MINUTE_ONE_HOUR_EXPIRED);
        ?>
        @include('beta.layouts.partials.banner_popup', ['banner' => $banner])
        <?php
    }
}
?>
<script type="text/javascript">(function(){window.abKiteCallAsyncInit=function(){abKiteCallSDK.init({credential:'yLrvCyup6ypoDvxFJGzL',realm:'fitfoodvn.anttel-pro.ab-kz-02.antbuddy.com',kiteRoom:'Kite_uyG155pswFHCzL0xsHFEHGKp6oJ3Kw',abKiteServer:'kite.antbuddy.com',isHttps:"https:"===window.location.protocol});};(function(d, s, id){var js, fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return;} js=d.createElement(s);js.id=id;js.src='https://kite.antbuddy.com/call/sdk/v0.0.0/sdk.js';fjs.parentNode.insertBefore(js, fjs);}(document,'script','ab-call-kite-jssdk'));})();</script>
</body>
</html>