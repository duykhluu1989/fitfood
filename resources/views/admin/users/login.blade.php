<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>Fitfood Admin - Login</title>
    <?php
    echo Minify::stylesheet([
        '/../assets/css/bootstrap.min.css',
        '/../assets/css/metisMenu.min.css',
        '/../assets/css/font-awesome.min.css',
        '/../assets/css/jquery-ui.min.css',
    ])->withFullUrl();
    ?>
    <link href="{{ asset('assets/css/sb-admin-2.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="{{ request()->fullUrl() }}" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="text" autofocus="autofocus" required="required">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" required="required">
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Login" />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo Minify::javascript([
    '/../assets/js/jquery-2.2.4.min.js',
    '/../assets/js/jquery-ui.min.js',
    '/../assets/js/bootstrap.min.js',
    '/../assets/js/sb-admin-2.js',
    '/../assets/js/metisMenu.min.js',
])->withFullUrl();
?>
</body>
</html>