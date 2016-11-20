<div class="nav-home">
    <nav class="navbar" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary-navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand navbar-brand-centered" href="{{ url('/') }}">
                <img src="{{ asset('/../assets/images/logo-ver-white.png') }}" alt="Fitfood">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="primary-navigation">
            <ul class="nav navbar-nav">
                <li<?php echo (Request::is('/') ? ' class="active"' : ''); ?>>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li<?php echo (Request::is('menu') ? ' class="active"' : ''); ?>>
                    <a href="{{ url('menu') }}">Menu</a>
                </li>
                <li<?php echo (Request::is('order') ? ' class="active"' : ''); ?>>
                    <a href="{{ url('order') }}">Order</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li<?php echo (Request::is('blog') ? ' class="active"' : ''); ?>>
                    <a href="{{ url('blog') }}">Blog</a>
                </li>
                <li<?php echo (Request::is('faqs') ? ' class="active"' : ''); ?>>
                    <a href="{{ url('faqs') }}">FAQ</a>
                </li>
                <li>
                    <a href="https://www.facebook.com/fitfoodvietnam" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="https://www.instagram.com/fitfoodvn" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</div>