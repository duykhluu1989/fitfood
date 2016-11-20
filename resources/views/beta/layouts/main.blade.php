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
    ga('send', 'pageview');
</script>
@yield('content')
<div class="footer-widget">
    <div class="container">
        <div class="block hotline text-center">
            <i class="fa fa-mobile" aria-hidden="true"></i>
            <p>(+84) 9 3278 8120 <br />	(+84) 9 7124 8950</p>
        </div>
        <div class="block logo text-center">
            <img src="{{ asset('assets/images/logo-ver.png') }}" alt="Fitfood" border="0" />
        </div>
        <div class="block social text-center">
            <a href="https://www.facebook.com/fitfoodvietnam"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="https://www.instagram.com/fitfoodvn"><i class="fa fa-instagram" aria-hidden="true"></i></a>
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
        $bannerSrc = App\Models\Banner::getCustomerBanner(request(), App\Libraries\Util::BANNER_CUSTOMER_TYPE_OLD);
    else
        $bannerSrc = App\Models\Banner::getCustomerBanner(request(), App\Libraries\Util::BANNER_CUSTOMER_TYPE_NEW);

    if(!empty($bannerSrc))
    {
        Cookie::queue(App\Libraries\Util::COOKIE_SEE_BANNER_NAME, true, App\Libraries\Util::MINUTE_ONE_HOUR_EXPIRED);
        ?>
        @include('beta.layouts.partials.banner_popup', ['bannerSrc' => $bannerSrc])
        <?php
    }
}
?>
</body>
</html>