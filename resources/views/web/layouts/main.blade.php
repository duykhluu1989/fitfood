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
    <meta property="og:url" content="https://fitfood.vn" />
    <meta property="og:site_name" content="Fitfood" />
    <meta property="og:image" content="{{ asset('assets/img/logo.png') }}" />
    <meta property="og:locale" content="vi_VN" />
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>Fitfood - Weekly meals for a healthy lifestyle @yield('title')</title>
    {!! Minify::stylesheet([
        '/../assets/css/bootstrap.min.css',
        '/../assets/css/font-awesome.min.css',
        '/../assets/css/jquery-ui.min.css',
        '/../assets/css/magnific-popup.css',
        '/../assets/css/sweetalert.css',
    ])->withFullUrl() !!}
    <link href="{{ asset('assets/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/fitfood.css') }}" rel="stylesheet">
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
<div id="Wrapper" class="container-fluid">
    <div id="WrapperHeader" class="col-sm-12">
        <div class="row">
            <div id="TitleContain" class="col-sm-9">
                <p id="Title">
                    <a href="{{ url('/') }}">Fitfood.vn</a>
                </p>
                <p id="Slogan">
                    Weekly meals for a healthy lifestyle
                </p>
            </div>
            <div id="MenuContain" class="col-sm-3">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li<?php echo (Request::is('/') ? ' class="active"' : ''); ?>>
                                    <a href="{{ url('/') }}">HOME</a>
                                </li>
                                <li<?php echo (Request::is('order') ? ' class="active"' : ''); ?>>
                                    <a href="{{ url('order') }}">ORDER</a>
                                </li>
                                <li<?php echo (Request::is('menu') ? ' class="active"' : ''); ?>>
                                    <a href="{{ url('menu') }}">MENU</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <div id="WrapperBody" class="col-sm-12">
        <div class="row">
            @yield('content')
        </div>
    </div>
    <div id="WrapperFooter" class="col-sm-12">
        <div class="row">
            <div id="FooterCopyright" class="col-sm-10">
                <a href="https://www.facebook.com/fitfoodvietnam">Copyright © Fitfood.vn 2016</a>
            </div>
            <div id="FooterOpen" class="col-sm-2">
                <ul>
                    <li>
                        <a href="https://www.facebook.com/fitfoodvietnam" class="btn btn-circle">
                            <i class="fa fa-facebook-square fa-fw"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/fitfoodvn/" class="btn btn-circle">
                            <i class="fa fa-instagram fa-fw"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
{!! Minify::javascript([
    '/../assets/js/jquery-2.2.4.min.js',
    '/../assets/js/jquery-ui.min.js',
    '/../assets/js/bootstrap.min.js',
    '/../assets/js/sweetalert.min.js',
    '/../assets/js/magnific-popup.min.js',
    '/../assets/js/fitfood.js',
])->withFullUrl() !!}
@yield('script')
</body>
</html>
