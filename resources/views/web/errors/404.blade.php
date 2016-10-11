<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>Page not found</title>
</head>
<body style="background: #daecee;">
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-3551564-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
<div style="position: absolute;top: 50%;left: 50%;margin-top: -303px;margin-left: -303px;">
    <a href="{{ url('/') }}">
        <img src="{{ asset('assets/img/404.png') }}" alt="404 page not found" id="error404-image" />
    </a>
</div>
</body>
</html>

