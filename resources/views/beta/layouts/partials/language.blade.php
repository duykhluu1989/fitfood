<div class="language">
    <a href="{{ url('lang', ['lan' => 'en']) }}"<?php echo (App::getLocale() == 'en' ? ' class="active"' : ''); ?>>
        <img src="{{ asset('assets/img/ico_en.png') }}" width="80%" />
    </a>
    <a href="{{ url('lang', ['lan' => 'vi']) }}"<?php echo (App::getLocale() == 'vi' ? ' class="active"' : ''); ?>>
        <img src="{{ asset('assets/img/ico_vn.png') }}" width="80%" />
    </a>
</div>