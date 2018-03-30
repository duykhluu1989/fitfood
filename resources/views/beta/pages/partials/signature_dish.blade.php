<div class="signature-dish">
    @if($title == true)
        <h4>@lang('menu_page.signature')</h4>
    @endif
    <div class="block-3">
        <a class="FitfoodPopupImage" href="{{ App::getLocale() == 'en' ? asset('assets/images/package/Fit_Fullpackage_ENG_PNG.png') : asset('assets/images/package/Fit_Fullpackage_VIE_PNG.png') }}">
            <div class="hovereffect">
                <img class="img-responsive" src="{{ asset('/../assets/images/full.jpg') }}" alt="Fitfood" border="0" />

                <div class="overlay">
                    <h3 class="package">FULL PACKAGE <small>1400 Calories</small></h3>
                    <div class="time">
                        <h6>Breakfast - Lunch - Dinner</h6>
                    </div>
                    <p class="price">700.000 <small>vnd</small>/@lang('home_page.week')</p>
                </div>
            </div>
        </a>
    </div>
    <div class="block-3">
        <a class="FitfoodPopupImage" href="{{ App::getLocale() == 'en' ? asset('assets/images/package/Fit_Fitpackage_ENG_PNG.png') : asset('assets/images/package/Fit_Fitpackage_VIE_PNG.png') }}">
            <div class="hovereffect">
                <img class="img-responsive" src="{{ asset('/../assets/images/fit.jpg') }}" alt="Fitfood" border="0" />
                <div class="overlay">
                    <h3 class="package">FIT PACKAGE <small>1100 Calories</small></h3>
                    <div class="time">
                        <h6>@lang('home_page.fitMeal')</h6>
                    </div>
                    <p class="price">550.000 <small>vnd</small>/@lang('home_page.week')</p>
                </div>
            </div>
        </a>
    </div>
    <div class="block-3">
        <a class="FitfoodPopupImage" href="{{ App::getLocale() == 'en' ? asset('assets/images/package/Fit_MeatLover_ENG_PNG.png') : asset('assets/images/package/Fit_MeatLover_VIE_PNG.png') }}">
            <div class="hovereffect">
                <img class="img-responsive" src="{{ asset('/../assets/images/meat.jpg') }}" alt="Fitfood" border="0" />
                <div class="overlay">
                    <h3 class="package">MEAT LOVER <small>2000 Calories</small></h3>
                    <div class="time">
                        <h6>Lunch - Dinner @lang('home_page.meatLoverDescription')</h6>
                    </div>
                    <p class="price">900.000 <small>vnd</small>/@lang('home_page.week')</p>
                </div>
            </div>
        </a>
    </div>
    <div class="block-3">
        <a class="FitfoodPopupImage" href="{{ App::getLocale() == 'en' ? asset('assets/images/package/Fit_Vegetarian_ENG_PNG.png') : asset('assets/images/package/Fit_Vegetarian_VIE_PNG.png') }}">
            <div class="hovereffect">
                <img class="img-responsive" src="{{ asset('/../assets/images/vegetarian_package.jpg') }}" alt="Fitfood" border="0" />
                <div class="overlay">
                    <h3 class="package">VEGETARIAN <small>1000 Calories</small></h3>
                    <div class="time">
                        <h6>@lang('home_page.vegetarianMeal')</h6>
                    </div>
                    <p class="price">550.000 <small>vnd</small>/@lang('home_page.week')</p>
                </div>
            </div>
        </a>
    </div>
    <div class="clearfix"></div>
</div>
<div class="signature-dish" style="margin-top: 30px">
    <div class="block-3">
        <a href="{{ url('order') }}">
            <div class="hovereffect">
                <img class="img-responsive" src="{{ asset('/../assets/images/package/nuts.png') }}" alt="Fitfood" border="0" />
            </div>
        </a>
    </div>
    <div class="block-3">
        <a href="{{ url('order') }}">
            <div class="hovereffect">
                <img class="img-responsive" src="{{ asset('/../assets/images/package/cookie.png') }}" alt="Fitfood" border="0" />
            </div>
        </a>
    </div>
    <div class="block-3">
        <a href="{{ url('order') }}">
            <div class="hovereffect">
                <img class="img-responsive" src="{{ asset('/../assets/images/package/tempeh.jpg') }}" alt="Fitfood" border="0" />
            </div>
        </a>
    </div>
    <div class="block-3">
        <a href="{{ url('order') }}">
            <div class="hovereffect">
                <img class="img-responsive" src="{{ asset('/../assets/images/package/khoga.jpg') }}" alt="Fitfood" border="0" />
            </div>
        </a>
    </div>
    <div class="clearfix"></div>
</div>