<div class="nav-page">
    <nav class="navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary-navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('/../assets/images/logo-hoz.png') }}" alt="Fitfood">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="primary-navigation">
                <ul class="nav navbar-nav navbar-right">
                    <li<?php echo (Request::is('/') ? ' class="active"' : ''); ?>>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li<?php echo (Request::is('menu') ? ' class="active"' : ''); ?>>
                        <a href="{{ url('menu') }}">Menu</a>
                    </li>
                    <li<?php echo (Request::is('order') ? ' class="active"' : ''); ?>>
                        <a href="{{ url('order') }}">Order</a>
                    </li>
                    <li<?php echo (Request::is('blog') ? ' class="active"' : ''); ?>>
                        <a href="{{ url('blog') }}">Blog</a>
                    </li>
                    <li<?php echo (Request::is('frequently-asked-questions') ? ' class="active"' : ''); ?>>
                        <a href="{{ url('frequently-asked-questions') }}">FAQ</a>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/fitfoodvietnam"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="https://www.instagram.com/fitfoodvn"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>