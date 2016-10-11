<div class="language">
    <a href="{{ url('lang', ['lan' => 'en']) }}"<?php echo (App::getLocale() == 'en' ? ' class="active"' : ''); ?>>EN</a>
    <a href="{{ url('lang', ['lan' => 'vi']) }}"<?php echo (App::getLocale() == 'vi' ? ' class="active"' : ''); ?>>VI</a>
</div>