@extends('web.layouts.main')

@section('content')

    <div class="col-sm-3">
        <div>
            <div id="Logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Fitfood" />
            </div>
            <div id="LogoTitle">
                Fitfood
            </div>
        </div>
        <br />
        <p>Fitfood provides weekly meals for a healthy lifestyle. If you are searching for great tasting, healthy meal plans in Saigon, we have a selection of dishes that will keep you energetic during the week.</p>
        <br />
        <p>We deliver directly to your door step, saving you time, energy and take the hassle out of cooking.</p>
        <br />
        <p>For more information, please visit our <a class="ContentLink" href="https://www.facebook.com/fitfoodvietnam">fanpage</a>. Don't know how it works ? Check out our <a class="ContentLink" href="https://www.facebook.com/notes/fitfood-vn/fitfoodvn-faq-english/953036278097913">FAQs</a>.</p>
        <br />
        <p>We are working on our website and it will be launched soon. Now taking ORDER via <a class="ContentLink" href="{{ url('order') }}">fitfood.vn/order</a></p>
        <br />
        <p>
            Call Us
            <br />
            (+84) 9 3278 8120
            <br />
            (+84) 9 7124 8950
        </p>
    </div>

    <div class="col-sm-3">
        <div class="ThumbnailHome">
            <img src="{{ asset('assets/img/fitfood-image3.png') }}" alt="Fitfood" width="100%" height="100%" />
            <div class="ThumbnailLayer">
            </div>
            <div class="ThumbnailCaption">
                <a class="ThumbnailCaptionLink" href="https://www.facebook.com/fitfoodvietnam"></a>
                <div class="Caption">
                    <a href="https://www.facebook.com/fitfoodvietnam" class="CaptionTitle">Black Packaging</a>
                    <br />
                    <a href="https://www.facebook.com/fitfoodvietnam" class="CaptionDescription">Exclusively at Fitfood</a>
                </div>
            </div>
        </div>
        <br />
        <br />
        <div class="ThumbnailHome">
            <img src="{{ asset('assets/img/fitfood-package2.png') }}" alt="Fitfood" width="100%" height="100%" />
            <div class="ThumbnailLayer">
            </div>
            <div class="ThumbnailCaption">
                <a class="ThumbnailCaptionLink" href="{{ url('order') }}"></a>
                <div class="Caption">
                    <a href="{{ url('order') }}" class="CaptionTitle">ORDER NOW</a>
                    <br />
                    <a href="{{ url('order') }}" class="CaptionDescription">For daily office meals<br />2 meals/day, 5 days/week</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="ThumbnailHome">
            <img src="{{ asset('assets/img/fitfood-package1.png') }}" alt="Fitfood" width="100%" height="100%" />
            <div class="ThumbnailLayer">
            </div>
            <div class="ThumbnailCaption">
                <a class="ThumbnailCaptionLink" href="{{ url('order') }}"></a>
                <div class="Caption">
                    <a href="{{ url('order') }}" class="CaptionTitle">ORDER NOW</a>
                    <br />
                    <a href="{{ url('order') }}" class="CaptionDescription">Suitable for weight loss purpose.<br />3 meals/day, 5 days/week</a>
                </div>
            </div>
        </div>
        <br />
        <br />
        <div class="ThumbnailHome">
            <img src="{{ asset('assets/img/fitfood-image1.png') }}" alt="Fitfood" width="100%" height="100%" />
            <div class="ThumbnailLayer">
            </div>
            <div class="ThumbnailCaption">
                <a class="ThumbnailCaptionLink" href="https://www.facebook.com/fitfoodvietnam"></a>
                <div class="Caption">
                    <a href="https://www.facebook.com/fitfoodvietnam" class="CaptionTitle">Fit & Healthy</a>
                    <br />
                    <a href="https://www.facebook.com/fitfoodvietnam" class="CaptionDescription">Fresh & Green ingredients</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="ThumbnailHome">
            <img src="{{ asset('assets/img/fitfood-image2.png') }}" alt="Fitfood" width="100%" height="100%" />
            <div class="ThumbnailLayer">
            </div>
            <div class="ThumbnailCaption">
                <a class="ThumbnailCaptionLink" href="https://www.facebook.com/fitfoodvietnam"></a>
                <div class="Caption">
                    <a href="https://www.facebook.com/fitfoodvietnam" class="CaptionTitle">High Quality</a>
                    <br />
                    <a href="https://www.facebook.com/fitfoodvietnam" class="CaptionDescription">Free from MSG & low sugar</a>
                </div>
            </div>
        </div>
        <br />
        <br />
        <div class="ThumbnailHome">
            <img src="{{ asset('assets/img/fitfood-package3.png') }}" alt="Fitfood" width="100%" height="100%" />
            <div class="ThumbnailLayer">
            </div>
            <div class="ThumbnailCaption">
                <a class="ThumbnailCaptionLink" href="{{ url('order') }}"></a>
                <div class="Caption">
                    <a href="{{ url('order') }}" class="CaptionTitle">ORDER NOW</a>
                    <br />
                    <a href="{{ url('order') }}" class="CaptionDescription">Fitness & Gym<br>2 meals/day with Extra Protein</a>
                </div>
            </div>
        </div>
    </div>

@stop