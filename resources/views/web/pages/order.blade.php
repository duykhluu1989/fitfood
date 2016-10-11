@extends('web.layouts.main')

@section('content')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-4">
                <ul id="OrderLang">
                    <li>
                        <a href="{{ url('lang', ['lan' => 'en']) }}">
                            <img src="{{ asset('assets/img/ico_en.png') }}" alt="Fitfood" />
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lang', ['lan' => 'vi']) }}">
                            <img src="{{ asset('assets/img/ico_vn.png') }}" alt="Fitfood" />
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-8" id="OrderFormTitle">
                <p>ORDER FORM</p>
            </div>
        </div>
    </div>

    <div class="col-sm-12" id="OrderFormBody">
        <form action="{{ url('order') }}" method="post" id="OrderForm" autocomplete="off">
            <div class="row">
                <div class="col-sm-4">
                    <br />
                    <div class="form-group">
                        <label>@lang('order_form.customerInfo')</label>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control InputRequired" id="OrderInputPhone" name="phone" placeholder="@lang('order_form.phone')" autofocus="autofocus" required="required" />
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control InputRequired" name="name" placeholder="@lang('order_form.name')" required="required" />
                    </div>

                    <div class="form-group">
                        <select class="form-control InputRequired" name="gender" required="required">
                            <option value="">@lang('order_form.gender')</option>
                            @foreach(App\Libraries\Util::getGender(null, App::getLocale()) as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control InputRequired" name="email" placeholder="@lang('order_form.email')" required="required" />
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control InputRequired" id="OrderInputAddress" name="address" placeholder="@lang('order_form.address')" required="required" />
                    </div>

                    <div class="form-group">
                        <select class="form-control InputRequired" id="OrderDropDownDistrict" name="district" required="required">
                            <option value="">@lang('order_form.district')</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->name . (!empty($area->shipping_price) ? ' (Ship: ' . App\Libraries\Util::formatMoney($area->shipping_price * $normalMenuDays / 5) . ')' : '') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control InputRequired" id="OrderDropDownShippingTime" name="shipping_time" required="required">
                            <option value="">@lang('order_form.time')</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control InputRequired" name="payment_gateway" required="required">
                            <option value="">@lang('order_form.payment')</option>
                            @foreach(App\Libraries\Util::getPaymentMethod(null, App::getLocale()) as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" name="note" placeholder="@lang('order_form.note')"></textarea>
                    </div>
                </div>

                <div class="col-sm-5" id="OrderFormMealPackQuantity">
                    <br />
                    <div class="form-group">
                        <label>@lang('order_form.choosePack')</label>
                        @if(isset($currentNormalMenu) && !empty($currentNormalMenu->image_src))
                            <a href="{{ $currentNormalMenu->image_src }}" class="btn btn-primary btn-outline pull-right MenuPopUpImage">
                                @lang('order_form.menu')
                            </a>
                        @endif
                    </div>
                    <div id="OrderFormListMealPack">
                        @foreach($mealPacks as $mealPack)
                            <div class="row OrderFormMealPack">
                                <span class="col-sm-8 col-xs-6">
                                    <?php
                                    if(App::getLocale() == 'en' && !empty($mealPack->name_en))
                                        $mealPackName = $mealPack->name_en;
                                    else
                                        $mealPackName = $mealPack->name;
                                    if($mealPackName == 'VEGETARIAN')
                                    {
                                        if(isset($currentVegetarianMenu) && !empty($currentVegetarianMenu->image_src))
                                            echo '<label class="btn-link MenuPopUpImage" data-mfp-src="' . $currentVegetarianMenu->image_src . '">';
                                        else
                                            echo '<label class="btn-link">';
                                    }
                                    else if($mealPackName == 'JUS SWEETIE')
                                        echo '<label id="OrderFormMenuJusSweetPopup" class="btn-link">';
                                    else if($mealPackName == 'JUS GREENIE')
                                        echo '<label id="OrderFormMenuJusGreenPopup" class="btn-link">';
                                    else if($mealPackName == 'MIXED NUTS')
                                        echo '<label id="OrderFormMenuNutsPopup" class="btn-link">';
                                    echo $mealPackName;
                                    if($mealPackName == 'VEGETARIAN' || $mealPackName == 'JUS SWEETIE' || $mealPackName == 'JUS GREENIE' || $mealPackName == 'MIXED NUTS')
                                        echo '</label>';
                                    $description = null;
                                    $miniDescription = null;
                                    if(App::getLocale() == 'en' && !empty($mealPack->description_en))
                                        $description = $mealPack->description_en;
                                    else if(!empty($mealPack->description))
                                        $description = $mealPack->description;
                                    if(App::getLocale() == 'en' && !empty($mealPack->mini_description_en))
                                        $miniDescription = $mealPack->mini_description_en;
                                    else if(!empty($mealPack->mini_description))
                                        $miniDescription = $mealPack->mini_description;
                                    ?>
                                    <span class="hidden-md hidden-lg">
                                        @if(!empty($miniDescription))
                                            {{ ' (' . $miniDescription . ')' }}
                                        @endif
                                    </span>
                                    <span class="hidden-xs hidden-sm">
                                        @if(!empty($description))
                                            {{ ' (' . $description . ')' }}
                                        @endif
                                    </span>
                                </span>
                                <input type="text" class="OrderFormMealPackQuantityInput" id="OrderFormMealPackQuantityInput_{{ $mealPack->id }}" name="mealPack[{{ $mealPack->id }}]" />
                                <span class="col-xs-2">
                                    @if(!empty($mealPack->breakfast) || !empty($mealPack->lunch) || !empty($mealPack->dinner))
                                        {{ App\Libraries\Util::formatMoney($mealPack->price * $normalMenuDays / 5) }}
                                    @else
                                        {{ App\Libraries\Util::formatMoney($mealPack->price) }}
                                    @endif
                                </span>
                                @if(!empty($mealPack->breakfast) || !empty($mealPack->lunch) || !empty($mealPack->dinner))
                                    <input type="hidden" id="OrderFormMealPackPrice_{{ $mealPack->id }}" value="{{ $mealPack->price * $normalMenuDays / 5 }}" />
                                @else
                                    <input type="hidden" id="OrderFormMealPackPrice_{{ $mealPack->id }}" value="{{ $mealPack->price }}" />
                                @endif
                                @if(!empty($mealPack->breakfast) || !empty($mealPack->lunch) || !empty($mealPack->dinner))
                                    <input type="hidden" id="MainMealPack_{{ $mealPack->id }}" value="{{ $mealPack->id }}" />
                                @endif
                                <?php
                                $doubles = array();
                                if(!empty($mealPack->double))
                                    $doubles = json_decode($mealPack->double, true);
                                ?>
                                @if(empty($mealPack->breakfast) && (!empty($mealPack->lunch) || !empty($mealPack->dinner)) && isset($doubles['lunch']) && isset($doubles['dinner']))
                                    <input type="hidden" id="NoBreakfastMainMealPack_{{ $mealPack->id }}" value="{{ $mealPack->id }}" />
                                @endif
                                @if(empty($mealPack->breakfast) && empty($mealPack->lunch) && empty($mealPack->dinner) && empty($mealPack->fruit) && empty($mealPack->veggies) && empty($mealPack->vegetarian)
                                    && !empty($mealPack->juice))
                                    <input type="hidden" id="SideJusPack_{{ $mealPack->id }}" value="{{ $mealPack->id }}" />
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <hr />
                    <div class="row">
                        <span class="col-xs-9">@lang('order_form.shippingPrice')</span>
                        <span class="col-xs-2" id="ShippingPrice">0</span>
                    </div>
                    <div class="row">
                        <span class="col-xs-9">@lang('order_form.extraPrice')</span>
                        <span class="col-xs-2" id="ExtraPrice">0</span>
                    </div>
                    <hr />
                    <div class="row">
                        <span class="col-xs-9">@lang('order_form.discountPrice')</span>
                        <span class="col-xs-2" id="DiscountPrice">0</span>
                    </div>
                    <br />
                    <div class="row" style="background: #f0f0f0;padding-top: 20px;padding-bottom: 20px">
                        <label class="col-xs-9">@lang('order_form.total')</label>
                        <label class="col-xs-2" id="TotalMealPackPrice">0</label>
                    </div>
                </div>

                <div class="col-sm-3">
                    <br />
                    <div class="form-group">
                        <label>@lang('order_form.request')</label>
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="OrderDropDownChangeIngredient" name="change_ingredient">
                            <option value="">@lang('order_form.changeIngredient')</option>
                            @foreach(App\Libraries\Util::getRequestChangeIngredient(null, App::getLocale()) as $value => $label)
                                <option value="{{ $value }}">{{ $label . ' (' . App\Libraries\Util::formatMoney(App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE) . ')' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="OrderCheckChangeMeal" name="change_meal_course" value="<?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_VALUE; ?>" />
                            <?php echo (App::getLocale() == 'en' ? App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL_EN : App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL); ?> (<?php echo App\Libraries\Util::formatMoney(App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_PRICE); ?>)
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="OrderCheckExtraBreakfast" name="extra_breakfast" value="<?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_VALUE; ?>" disabled="disabled" />
                            <?php echo (App::getLocale() == 'en' ? App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL_EN : App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL); ?> (<?php echo App\Libraries\Util::formatMoney(App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>)
                        </label>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label>@lang('order_form.discountCode')</label>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="discount_code" id="OrderInputDiscountCode" placeholder="@lang('order_form.inputDiscount')" />
                    </div>

                    <div class="form-group">
                        <button type="button" class="form-control btn btn-success" id="OrderButtonUseDiscountCode">@lang('order_form.useDiscount')</button>
                    </div>
                    <hr />
                    <br />
                    <div class="form-group">
                        <button type="submit" id="OrderFormSubmitButton" class="btn btn-primary btn-lg col-xs-12" style="height: 70px"><b>@lang('order_form.placeOrder')</b></button>
                    </div>
                </div>
            </div>

            <input type="hidden" id="OrderInputAddressGoogle" name="address_google" />
            <input type="hidden" id="AddressLatitude" name="latitude" />
            <input type="hidden" id="AddressLongitude" name="longitude" />

            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        </form>
    </div>

    <div class="col-sm-12" id="GoogleMap"></div>

    @include('admin.layouts.partials.loading')

@stop

@section('script')

    <script type="text/javascript">

        function initMap()
        {
            var lat = 10.771808;
            var lng = 106.67818;
            var latLng = new google.maps.LatLng(lat, lng);
            var image = 'http://maps.google.com/mapfiles/ms/micons/red-dot.png';

            var mapOptions = {
                center: new google.maps.LatLng(lat, lng),
                zoom: 17,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map = new google.maps.Map(document.getElementById('GoogleMap'), mapOptions);

            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                animation: google.maps.Animation.DROP,
                icon: image,
                draggable: true
            });

            var orderInputAddressElem = document.getElementById('OrderInputAddress');
            var googleAutoComplete = new google.maps.places.Autocomplete(orderInputAddressElem, {

                componentRestrictions: {
                    country: 'VN'
                }

            });

            googleAutoComplete.bindTo('bounds', map);
            var infoWindow = new google.maps.InfoWindow();

            googleAutoComplete.addListener('place_changed', function() {

                infoWindow.close();
                var place = googleAutoComplete.getPlace();

                if(place.geometry.viewport)
                    map.fitBounds(place.geometry.viewport);
                else
                {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                moveMarker(place.formatted_address, place.geometry.location);
                detectDistrict(place);

            });

            var geoCoder = new google.maps.Geocoder();

            orderInputAddressElem.addEventListener('change', function() {

                var address = this.value;

                if(address != '')
                {
                    geoCoder.geocode({

                        address: address,
                        componentRestrictions: {
                            country: 'VN'
                        }

                    }, function(results, status) {

                        if(status == google.maps.GeocoderStatus.OK) {

                            moveMarker(results[0].formatted_address, results[0].geometry.location);
                            detectDistrict(results[0]);

                        }

                    });
                }

            });

            marker.addListener('dragend', function() {

                geoCoder.geocode({

                    latLng: marker.getPosition()

                }, function(results, status) {

                    if(status == google.maps.GeocoderStatus.OK) {

                        moveMarker(results[0].formatted_address, results[0].geometry.location);
                        detectDistrict(results[0]);

                    }

                });

            });

            function moveMarker(placeName, latlng)
            {
                marker.setIcon(image);
                marker.setPosition(latlng);
                infoWindow.setContent(placeName);
                infoWindow.open(map, marker);

                document.getElementById('OrderInputAddressGoogle').value = placeName;
                document.getElementById('AddressLatitude').value = latlng.lat();
                document.getElementById('AddressLongitude').value = latlng.lng();
            }

            function detectDistrict(placeObj)
            {
                if(placeObj.address_components.length >= 5)
                {
                    if(placeObj.address_components[4])
                    {
                        var addressValue = document.getElementById('OrderInputAddress').value;

                        if(addressValue.indexOf(placeObj.address_components[4].long_name) == -1)
                            addressValue = addressValue + ', ' + placeObj.address_components[4].long_name;

                        document.getElementById('OrderInputAddress').value = addressValue;
                    }
                }
            }
        }

        $(document).ready(function() {

            $('#OrderInputPhone').focusout(function() {

                var elem = $(this);
                var elemVal = elem.val().trim();

                var pattern = /^0[0-9]{7,10}$/;

                if(elemVal == '' || !pattern.test(elemVal))
                    elem.parent().addClass('has-error');
                else
                    elem.parent().removeClass('has-error');

            }).change(function() {

                removeDiscount();

            });

            $('#OrderDropDownDistrict').change(function() {

                var elemVal = $(this).val().trim();
                var listDistricts = {
                    @foreach($areas as $area)
                        '{{ $area->id }}': {
                            'shipping_price': '{{ $area->shipping_price * $normalMenuDays / 5 }}',
                            'shipping_time': {
                                <?php $shippingTimes = json_decode($area->shipping_time, true); ?>
                                @foreach($shippingTimes as $value => $label)
                                    @if($value != App\Libraries\Util::SHIPPING_TIME_NIGHT_BEFORE_VALUE)
                                        '{{ $value }}': '{{ $label }}',
                                    @else
                                        '{{ $value }}': '{{ (App::getLocale() == 'en' ? App\Libraries\Util::SHIPPING_TIME_NIGHT_BEFORE_LABEL_EN : $label) }}',
                                    @endif
                                @endforeach
                            }
                        },
                    @endforeach
                };

                var shippingTimeElem = $('#OrderDropDownShippingTime');

                var totalTempElem = $('#TotalMealPackPrice');
                var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                var shippingPriceElem = $('#ShippingPrice');
                var shippingPriceVal = parseInt(shippingPriceElem.html().split('.').join(''));

                totalTempVal -= shippingPriceVal;

                if(elemVal != '')
                {
                    shippingTimeElem.html('<option value="">@lang('order_form.time')</option>');

                    for(var key in listDistricts[elemVal].shipping_time)
                        shippingTimeElem.append('<option value="' + key + '">' + listDistricts[elemVal].shipping_time[key] + '</option>');

                    shippingPriceElem.html(formatMoney(listDistricts[elemVal].shipping_price));
                    totalTempVal += parseInt(listDistricts[elemVal].shipping_price);
                }
                else
                {
                    shippingPriceElem.html(0);
                    shippingTimeElem.html('<option value="">@lang('order_form.time')</option>');
                }

                totalTempElem.html(formatMoney(totalTempVal.toString()));

                removeDiscount();

            });

            $.widget('ui.spinner', $.ui.spinner, {

                _uiSpinnerHtml: function() {
                    return '<span class="ui-spinner ui-widget ui-widget-content col-xs-2"></span>';
                }

            });

            $('.OrderFormMealPackQuantityInput').spinner({

                min: 0,
                spin: function(event, ui) {

                    var elem = $(this);
                    var elemOldVal = elem.val();
                    var idArr = elem.prop('id').split('_');

                    var totalTempElem = $('#TotalMealPackPrice');
                    var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                    if(elemOldVal == '')
                        totalTempVal += parseInt(ui.value) * parseInt($('#OrderFormMealPackPrice_' + idArr[1]).val());
                    else
                    {
                        if(ui.value > elemOldVal)
                            totalTempVal += (parseInt(ui.value) - parseInt(elemOldVal)) * parseInt($('#OrderFormMealPackPrice_' + idArr[1]).val());
                        else
                            totalTempVal -= (parseInt(elemOldVal) - parseInt(ui.value)) * parseInt($('#OrderFormMealPackPrice_' + idArr[1]).val());
                    }

                    totalTempElem.html(formatMoney(totalTempVal.toString()));

                    removeDiscount();

                    var extraBreakfastElem = $('#OrderCheckExtraBreakfast');

                    if($('#NoBreakfastMainMealPack_' + idArr[1]).length > 0)
                    {
                        if(ui.value > 0)
                            extraBreakfastElem.removeAttr('disabled');
                        else
                        {
                            if(extraBreakfastElem.prop('checked') == true)
                            {
                                extraBreakfastElem.removeAttr('checked');
                                extraBreakfastElem.trigger('change');
                            }

                            extraBreakfastElem.prop('disabled', 'disabled');
                        }
                    }

                }

            });

            var orderDropDownChangeIngredientOldVal;

            $('#OrderDropDownChangeIngredient').click(function(event) {

                orderDropDownChangeIngredientOldVal = $(this).val();

            }).change(function() {

                var totalTempElem = $('#TotalMealPackPrice');
                var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                var extraPriceElem = $('#ExtraPrice');
                var extraPriceVal = parseInt(extraPriceElem.html().split('.').join(''));

                if($(this).val() != '' && orderDropDownChangeIngredientOldVal == '')
                {
                    extraPriceVal += <?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE; ?>;
                    totalTempVal += <?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE; ?>;

                    extraPriceElem.html(formatMoney(extraPriceVal.toString()));
                    totalTempElem.html(formatMoney(totalTempVal.toString()));

                    removeDiscount();
                }
                else if($(this).val() == '' && orderDropDownChangeIngredientOldVal != '')
                {
                    extraPriceVal -= <?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE; ?>;
                    totalTempVal -= <?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE; ?>;

                    extraPriceElem.html(formatMoney(extraPriceVal.toString()));
                    totalTempElem.html(formatMoney(totalTempVal.toString()));

                    removeDiscount();
                }

            });

            $('#OrderCheckChangeMeal').change(function() {

                var totalTempElem = $('#TotalMealPackPrice');
                var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                var extraPriceElem = $('#ExtraPrice');
                var extraPriceVal = parseInt(extraPriceElem.html().split('.').join(''));

                if($(this).prop('checked') == true)
                {
                    extraPriceVal += <?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_PRICE; ?>;
                    totalTempVal += <?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_PRICE; ?>;
                }
                else
                {
                    extraPriceVal -= <?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_PRICE; ?>;
                    totalTempVal -= <?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_PRICE; ?>;
                }

                extraPriceElem.html(formatMoney(extraPriceVal.toString()));
                totalTempElem.html(formatMoney(totalTempVal.toString()));

                removeDiscount();

            });

            $('#OrderCheckExtraBreakfast').change(function() {

                var totalTempElem = $('#TotalMealPackPrice');
                var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                var extraPriceElem = $('#ExtraPrice');
                var extraPriceVal = parseInt(extraPriceElem.html().split('.').join(''));

                if($(this).prop('checked') == true)
                {
                    extraPriceVal += <?php echo (App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE  * $normalMenuDays / 5); ?>;
                    totalTempVal += <?php echo (App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>;
                }
                else
                {
                    extraPriceVal -= <?php echo (App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>;
                    totalTempVal -= <?php echo (App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>;
                }

                extraPriceElem.html(formatMoney(extraPriceVal.toString()));
                totalTempElem.html(formatMoney(totalTempVal.toString()));

                removeDiscount();

            });

            $('#OrderButtonUseDiscountCode').click(function() {

                var discountCode = $('#OrderInputDiscountCode').val();

                if(discountCode.trim() == '')
                {
                    sweetAlert({

                        title: 'Oops...',
                        text: '@lang('order_form.enterDiscountCode')',
                        type: 'error',
                        allowOutsideClick: true

                    });
                }
                else
                {
                    var totalTempElem = $('#TotalMealPackPrice');
                    var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                    var discountPriceElem = $('#DiscountPrice');
                    var discountPriceVal = parseInt(discountPriceElem.html().split('.').join(''));

                    var mealPackQuantityList = $('.OrderFormMealPackQuantityInput');
                    var packQuantityPost = '';
                    var idArr;

                    mealPackQuantityList.each(function() {

                        idArr = $(this).prop('id').split('_');

                        if($(this).val().trim() != '' && !isNaN($(this).val().trim()) && $(this).val().trim() > 0)
                            packQuantityPost += '&pack[' + idArr[1] + ']=' + $(this).val().trim();

                    });

                    showLoadingScreen();

                    $.ajax({
                        url: '{{ url('checkDiscountCode') }}',
                        type: 'post',
                        data: '_token={{ csrf_token() }}&code=' + discountCode.trim() + '&phone=' + $('#OrderInputPhone').val().trim() + packQuantityPost,
                        success: function(result) {

                            if(result)
                            {
                                closeLoadingScreen();

                                if(result == 'INVALID_CODE')
                                {
                                    sweetAlert({

                                        title: 'Oops...',
                                        text: '@lang('order_form.invalidDiscountCode')',
                                        type: 'error',
                                        allowOutsideClick: true

                                    });
                                }
                                else if(result == 'EXPIRED')
                                {
                                    sweetAlert({

                                        title: 'Oops...',
                                        text: '@lang('order_form.expiredDiscountCode')',
                                        type: 'error',
                                        allowOutsideClick: true

                                    });
                                }
                                else if(!isNaN(result))
                                {
                                    if(parseInt(result) == 0)
                                    {
                                        sweetAlert({

                                            title: 'Oops...',
                                            text: '@lang('order_form.invalidDiscountCode')',
                                            type: 'error',
                                            allowOutsideClick: true

                                        });
                                    }
                                    else
                                    {
                                        totalTempVal += discountPriceVal;
                                        totalTempVal -= parseInt(result);

                                        discountPriceElem.html(formatMoney(result.toString()));
                                        totalTempElem.html(formatMoney(totalTempVal.toString()));

                                        sweetAlert({

                                            title: 'Hoooray',
                                            text: '@lang('order_form.useCodeSuccess')',
                                            type: 'success',
                                            allowOutsideClick: true

                                        });
                                    }
                                }
                            }

                        }
                    });
                }

                return false;

            });

            function removeDiscount()
            {
                var discountPriceElem = $('#DiscountPrice');
                var discountPriceVal = parseInt(discountPriceElem.html().split('.').join(''));

                $('#OrderInputDiscountCode').val('');

                if(discountPriceVal != 0)
                {
                    var totalTempElem = $('#TotalMealPackPrice');
                    var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                    totalTempVal += discountPriceVal;

                    discountPriceElem.html(0);
                    totalTempElem.html(formatMoney(totalTempVal.toString()));
                }
            }

            $('#OrderInputAddress').keydown(function(e) {

                var keyCode = e.keyCode || e.which;
                if(keyCode === 13)
                {
                    e.preventDefault();
                    return false;
                }

            });

            $('.MenuPopUpImage').magnificPopup({

                type: 'image'

            });

            $('#OrderFormMenuJusSweetPopup').magnificPopup({

                items: {
                    src: '{{ asset('assets/img/jus_sweetie.png') }}'
                },
                type: 'image'

            });

            $('#OrderFormMenuJusGreenPopup').magnificPopup({

                items: {
                    src: '{{ asset('assets/img/jus_greenie.png') }}'
                },
                type: 'image'

            });

            $('#OrderFormMenuNutsPopup').magnificPopup({

                items: {
                    src: '{{ asset('assets/img/nuts.png') }}'
                },
                type: 'image'

            });

            $('#OrderForm').submit(function() {

                $('#OrderFormSubmitButton').prop('disabled', 'disabled');

                var idArr;
                var mealPackQuantityList = $('.OrderFormMealPackQuantityInput');

                var totalMealPack = 0;
                var mealValid = false;

                mealPackQuantityList.each(function() {

                    idArr = $(this).prop('id').split('_');

                    if($(this).val().trim() != '' && !isNaN($(this).val().trim()) && $(this).val().trim() > 0)
                    {
                        if($('#MainMealPack_' + idArr[1]).length > 0)
                            mealValid = true;

                        totalMealPack += parseInt($(this).val().trim());
                    }

                });

                if(mealValid == false)
                {
                    mealPackQuantityList.first().focus();

                    sweetAlert({

                        title: 'Oops...',
                        text: '@lang('order_form.invalidQuantity')',
                        type: 'error',
                        allowOutsideClick: true

                    });

                    $('#OrderFormSubmitButton').removeAttr('disabled', 'disabled');
                    return false;
                }

                if(totalMealPack > 5)
                {
                    mealPackQuantityList.first().focus();

                    sweetAlert({

                        title: 'Oops...',
                        text: '@lang('order_form.overQuantity')',
                        type: 'error',
                        allowOutsideClick: true

                    });

                    $('#OrderFormSubmitButton').removeAttr('disabled', 'disabled');
                    return false;
                }

                var inputPhone = $('#OrderInputPhone');
                var inputPhoneVal = inputPhone.val().trim();
                var pattern = /^0[0-9]{7,10}$/;

                if(inputPhoneVal == '' || !pattern.test(inputPhoneVal))
                {
                    inputPhone.focus();

                    sweetAlert({

                        title: 'Oops...',
                        text: '@lang('order_form.phoneInvalid')',
                        type: 'error',
                        allowOutsideClick: true

                    });

                    $('#OrderFormSubmitButton').removeAttr('disabled', 'disabled');
                    return false;
                }

            });

            @if(session('OrderError'))
            sweetAlert({

                title: 'Oops...',
                text: '<?php echo session()->pull('OrderError'); ?>',
                type: 'error',
                allowOutsideClick: true

            });
            @endif
        });

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap"></script>

@stop