<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>Fitfood Admin - @yield('title')</title>
    <?php
    echo Minify::stylesheet([
        '/../assets/css/bootstrap.min.css',
        '/../assets/css/metisMenu.min.css',
        '/../assets/css/font-awesome.min.css',
        '/../assets/css/jquery-ui.min.css',
        '/../assets/css/jquery.datetimepicker.min.css',
    ])->withFullUrl();
    ?>
    <link href="{{ asset('assets/css/sb-admin-2.css') }}" rel="stylesheet">
    @yield('stylesheet')
</head>
<body>
<div id="wrapper" <?php echo (Request::is('admin/order') ? 'style="width: 200%"' : ''); ?>>
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('admin') }}">Fitfood Admin</a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
                    <i class="fa fa-user fa-fw"></i>
                    {{ auth()->user()->username }}
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <a href="{{ url('admin/user/changePassword', ['id' => auth()->user()->id]) }}"><i class="fa fa-lock fa-fw"></i> Change Password</a>
                    </li>
                    <li>
                        <a href="{{ url('admin/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <form action="{{ url('admin/order/quickSearch') }}" method="get">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Quick Search Order" name="keyword" />
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><i class="fa fa-gear fa-fw"></i> Setting<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li {{ (Request::is('admin/setting') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/setting') }}">List Setting</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><i class="fa fa-user fa-fw"></i> User<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li {{ (Request::is('admin/role') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/role') }}">List Role</a>
                            </li>
                            <li {{ (Request::is('admin/user') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/user') }}">List User</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><i class="fa fa-pencil fa-fw"></i> Blog<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li {{ (Request::is('admin/blogCategory') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/blogCategory') }}">List Category</a>
                            </li>
                            <li {{ (Request::is('admin/article') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/article') }}">List Article</a>
                            </li>
                            <li {{ (Request::is('admin/tag') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/tag') }}">List Tag</a>
                            </li>
                            <li {{ (Request::is('admin/widget') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/widget') }}">List Widget</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><i class="fa fa-truck fa-fw"></i> Shipping<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li {{ (Request::is('admin/shipper') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/shipper') }}">List Shipper</a>
                            </li>
                            <li {{ (Request::is('admin/area') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/area') }}">List District</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><i class="fa fa-file-text fa-fw"></i> Menu<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li {{ (Request::is('admin/category') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/category') }}">List Category</a>
                            </li>
                            <li {{ (Request::is('admin/unit') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/unit') }}">List Unit</a>
                            </li>
                            <li {{ (Request::is('admin/resource') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/resource') }}">List Resource</a>
                            </li>
                            <li {{ (Request::is('admin/recipe') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/recipe') }}">List Recipe</a>
                            </li>
                            <li {{ (Request::is('admin/menu') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/menu') }}">List Menu</a>
                            </li>
                            <li {{ (Request::is('admin/mealPack') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/mealPack') }}">List Meal Pack</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><i class="fa fa-gift fa-fw"></i> Discount<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li {{ (Request::is('admin/discount') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/discount') }}">List Discount</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><i class="fa fa-users fa-fw"></i> Customer<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li {{ (Request::is('admin/customer') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/customer') }}">List Customer</a>
                            </li>
                            <li {{ (Request::is('admin/banner') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/banner') }}">List Banner</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><i class="fa fa-inbox fa-fw"></i> Order<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li {{ (Request::is('admin/order') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/order') }}">List Order</a>
                            </li>
                            <li {{ (Request::is('admin/cooking') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/cooking') }}">List Cooking</a>
                            </li>
                            <li {{ (Request::is('admin/assignShipping') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/assignShipping') }}">Assign Shipping</a>
                            </li>
                            <li {{ (Request::is('admin/shipping') ? 'class="active"' : '') }}>
                                <a href="{{ url('admin/shipping') }}">List Shipping</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">@yield('header')</h1>
            </div>
        </div>
        <div class="row">
            @yield('content')
        </div>
        <hr />
    </div>
</div>
<?php
echo Minify::javascript([
    '/../assets/js/jquery-2.2.4.min.js',
    '/../assets/js/jquery-ui.min.js',
    '/../assets/js/bootstrap.min.js',
    '/../assets/js/sb-admin-2.js',
    '/../assets/js/metisMenu.min.js',
    '/../assets/js/jquery.datetimepicker.full.min.js',
    '/../assets/js/fitfood.js',
])->withFullUrl();
?>
@yield('script')

@if(session('QuickSearchOrderError'))
    <script type="text/javascript">
        alert('<?php echo session()->pull('QuickSearchOrderError'); ?>');
    </script>
@endif

</body>
</html>
