@extends('web.layouts.main')

@section('content')

    <div class="col-sm-3">
        <div>
            <div id="Logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Fitfood" />
            </div>
            <div id="LogoTitle">
                MENU
            </div>
        </div>
        <br />
        <p>
            Our Menu is a fusion of Asian and Western cuisine. Dishes are changed every week.
        </p>
        <br />
        <p>
            Each meal is designed by a 5-star hotel chef to ensure a right balance of diet while keep the standard at the highest. All meals are free from MSG and have low sugar content.
        </p>
        <br />
        <p>
            We are working on our website and it will be launched soon. Now taking ORDER via <a class="ContentLink" href="{{ url('order') }}">fitfood.vn/order</a>.
        </p>
        <br />
        <p>
            Call Us
            <br>
            (+84) 9 3278 8120
            <br>
            (+84) 9 7124 8950
            <br>
        </p>
    </div>

    <?php
    $menus = array();
    foreach($currentAndLastWeekMenus as $currentAndLastWeekMenu)
    {
        if($currentAndLastWeekMenu->type == App\Libraries\Util::TYPE_MENU_NORMAL_VALUE)
        {
            if($currentAndLastWeekMenu->status == App\Libraries\Util::STATUS_MENU_CURRENT_VALUE)
                $menus['currentNormal'] = $currentAndLastWeekMenu;
            else
                $menus['lastWeekNormal'] = $currentAndLastWeekMenu;
        }
        else
        {
            if($currentAndLastWeekMenu->status == App\Libraries\Util::STATUS_MENU_CURRENT_VALUE)
                $menus['currentVegetarian'] = $currentAndLastWeekMenu;
            else
                $menus['lastWeekVegetarian'] = $currentAndLastWeekMenu;
        }
    }
    ?>

    <div class="col-sm-9">
        @if(isset($menus['lastWeekNormal']) && !empty($menus['lastWeekNormal']->image_src))
            <p>
                <a class="ContentLink MenuPopUpImage" href="{{ $menus['lastWeekNormal']->image_src }}">LAST WEEK MENU | THỰC ĐƠN TUẦN TRƯỚC</a>
            </p>
            <br />
        @endif
        @if(isset($menus['currentNormal']) && !empty($menus['currentNormal']->image_src))
            <a class="MenuPopUpImage" href="{{ $menus['currentNormal']->image_src }}" style="outline: none">
                <img id="MenuImage" src="{{ $menus['currentNormal']->image_src }}" width="100%" height="100%" alt="Fitfood" />
            </a>
        @endif
    </div>

@stop

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('.MenuPopUpImage').magnificPopup({

                type: 'image'

            });

        });

    </script>

@stop

