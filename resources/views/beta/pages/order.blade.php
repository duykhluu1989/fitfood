@extends('beta.layouts.main')

@section('content')

    @include('beta.layouts.partials.menu')

    @include('beta.layouts.partials.header', ['banner' => asset('assets/images/page-header/order.jpg'), 'title' => 'Order'])

    <div class="container">
        <div class="row">
            <div id="primary" class="full-width">
                <div id="content" class="box-shadow">
                    <div class="wrap-order">

                        @include('beta.layouts.partials.language')

                        <div class="page-title">
                            <h2>@lang('order_form.howOrder')</h2>
                        </div>
                        <div class="row how-to-order">
                            <div class="col text-center">
                                <img src="{{ asset('assets/images/fill_order_form.png') }}" alt="Fitfood" border="0" />
                                <h5>@lang('order_form.fillForm')</h5>
                                <p>@lang('order_form.fillFormText')</p>
                            </div>
                            <div class="col text-center">
                                <img src="{{ asset('assets/images/confirm.png') }}" alt="Fitfood" border="0" />
                                <h5>@lang('order_form.confirm')</h5>
                                <p>@lang('order_form.confirmText')</p>
                            </div>
                            <div class="col text-center">
                                <img src="{{ asset('assets/images/enjoy.png') }}" alt="Fitfood" border="0" />
                                <h5>@lang('order_form.enjoy')</h5>
                                <p>@lang('order_form.enjoyText')</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="page-title">
                            <h2>Order form</h2>
                        </div>
                        <form role="form" action="{{ url('order') }}" method="post" id="FitfoodOrderForm">
                            <div class="frm-order">
                                <h5>@lang('order_form.customerInfo')</h5>
                                <div class="form-group">
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <input type="tel" class="form-control input-lg" id="FitfoodOrderInputPhone" name="phone" placeholder="* @lang('order_form.phone')" required="required" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <input type="text" class="form-control input-lg" name="name" placeholder="* @lang('order_form.name')" required="required" />
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <select class="form-control input-lg" name="gender" required="required">
                                            <option value="">* @lang('order_form.gender')</option>
                                            @foreach(App\Libraries\Util::getGender(null, App::getLocale()) as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <input type="email" class="form-control input-lg" name="email" placeholder="* @lang('order_form.email')" required="required" />
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <input type="text" class="form-control input-lg" id="FitfoodOrderInputAddress" name="address" placeholder="* @lang('order_form.address')" autocomplete="off" required="required" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <select class="form-control input-lg" id="FitfoodOrderDropDownDistrict" name="district" required="required">
                                            <option value="">* @lang('order_form.district')</option>
                                            @foreach($areas as $area)
                                                <option value="{{ $area->id }}">{{ $area->name . (!empty($area->shipping_price) ? ' (Ship: ' . App\Libraries\Util::formatMoney($area->shipping_price * $normalMenuDays / 5) . ')' : '') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <select class="form-control input-lg" id="FitfoodOrderDropDownShippingTime" name="shipping_time" required="required">
                                            <option value="">* @lang('order_form.time')</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <select class="form-control input-lg" name="payment_gateway" required="required">
                                            <option value="">* @lang('order_form.payment')</option>
                                            @foreach(App\Libraries\Util::getPaymentMethod(null, App::getLocale()) as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                        <textarea class="form-control" name="note" placeholder="@lang('order_form.note')"></textarea>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div id="FitfoodGoogleMap"></div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="button" class="btn btn-default FitfoodPopupImage"<?php echo ((isset($currentNormalMenu) && !empty($currentNormalMenu->image_src)) ? ' data-mfp-src="' . $currentNormalMenu->image_src . '"' : '') ?>>@lang('order_form.menu')</button>
                                </div>
                                <h5>@lang('order_form.choosePack')</h5>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>@lang('order_form.package')</th>
                                        <th>@lang('order_form.price')</th>
                                        <th>@lang('order_form.quantity')</th>
                                        <th>@lang('order_form.packageTotal')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($mealPacks as $mealPack)
                                        <tr>
                                            <td>
                                                @if(!empty($mealPack->image_src))
                                                    <a class="FitfoodPopupImage" href="{{ $mealPack->image_src }}">
                                                @endif
                                                        <strong>
                                                            <?php
                                                            if(App::getLocale() == 'en' && !empty($mealPack->name_en))
                                                                $mealPackName = $mealPack->name_en;
                                                            else
                                                                $mealPackName = $mealPack->name;
                                                            echo $mealPackName;
                                                            ?>
                                                        </strong>
                                                        <?php
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
                                                @if(!empty($mealPack->image_src))
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($mealPack->breakfast) || !empty($mealPack->lunch) || !empty($mealPack->dinner))
                                                    {{ App\Libraries\Util::formatMoney($mealPack->price * $normalMenuDays / 5) }}
                                                @else
                                                    {{ App\Libraries\Util::formatMoney($mealPack->price) }}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-number" data-type="minus" data-field="mealPack[{{ $mealPack->id }}]" disabled="disabled">
                                                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                                                        </button>
                                                    </span>
                                                    <input type="text" id="OrderFormMealPackQuantityInput_{{ $mealPack->id }}" name="mealPack[{{ $mealPack->id }}]" class="form-control input-number FitfoodOrderFormMealPackQuantityInput" value="0" min="0" max="5" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-number" data-type="plus" data-field="mealPack[{{ $mealPack->id }}]">
                                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                        </button>
                                                    </span>
                                                    @if(!empty($mealPack->breakfast) || !empty($mealPack->lunch) || !empty($mealPack->dinner))
                                                        <input type="hidden" id="FitfoodOrderFormMealPackPrice_{{ $mealPack->id }}" value="{{ $mealPack->price * $normalMenuDays / 5 }}" />
                                                    @else
                                                        <input type="hidden" id="FitfoodOrderFormMealPackPrice_{{ $mealPack->id }}" value="{{ $mealPack->price }}" />
                                                    @endif
                                                    @if(!empty($mealPack->breakfast) || !empty($mealPack->lunch) || !empty($mealPack->dinner))
                                                        <input type="hidden" id="FitfoodMainMealPack_{{ $mealPack->id }}" value="{{ $mealPack->id }}" />
                                                    @endif
                                                    <?php
                                                    $doubles = array();
                                                    if(!empty($mealPack->double))
                                                        $doubles = json_decode($mealPack->double, true);
                                                    ?>
                                                    @if(empty($mealPack->breakfast) && (!empty($mealPack->lunch) || !empty($mealPack->dinner)) && isset($doubles['lunch']) && isset($doubles['dinner']))
                                                        <input type="hidden" id="FitfoodNoBreakfastMainMealPack_{{ $mealPack->id }}" value="{{ $mealPack->id }}" />
                                                    @endif
                                                </div>
                                            </td>
                                            <td id="FitfoodOrderFormTotalPricePerPack_{{ $mealPack->id }}">0</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="frm-checkout">
                                <div class="block">
                                    <div class="box">
                                        <h4>@lang('order_form.request')</h4>
                                        <div class="row">
                                            <div class="col-lg-10 col-md-10">
                                                <select class="form-control" id="FitfoodOrderDropDownChangeIngredient" name="change_ingredient">
                                                    <option value="">@lang('order_form.changeIngredient')</option>
                                                    @foreach(App\Libraries\Util::getRequestChangeIngredient(null, App::getLocale()) as $value => $label)
                                                        <option value="{{ $value }}">{{ $label . ' (' . App\Libraries\Util::formatMoney(App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE) . ')' }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                <h5>
                                                    <i class="fa fa-info-circle fa-fw" data-toggle="tooltip" title="@lang('order_form.noteChangeIngredient')"></i>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="checkbox">
                                            <label><input type="checkbox" id="FitfoodOrderCheckChangeMeal" name="change_meal_course" value="<?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_VALUE; ?>" />
                                                <?php echo (App::getLocale() == 'en' ? App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL_EN : App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL); ?>
                                                <span><?php echo App\Libraries\Util::formatMoney(App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_PRICE); ?></span></label>
                                        </div>
                                        <div class="checkbox">
                                            <label><input type="checkbox" id="FitfoodOrderCheckExtraBreakfast" name="extra_breakfast" value="<?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_VALUE; ?>" disabled="disabled" />
                                                <?php echo (App::getLocale() == 'en' ? App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL_EN : App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL); ?>
                                                <span><?php echo App\Libraries\Util::formatMoney(App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?></span></label>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <h5>@lang('order_form.extraQuantity')</h5>
                                            </div>
                                            <div class="col-lg-4 col-md-4">
                                                <select class="form-control" id="FitfoodOrderDropDownExtraBreakfastQuantity" name="extra_breakfast_quantity" disabled="disabled"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box">
                                        <h4>@lang('order_form.discountCode')</h4>
                                        <div class="form-group">
                                            <label>@lang('order_form.inputDiscount')</label>
                                            <input type="text" class="form-control" name="discount_code" id="FitfoodOrderInputDiscountCode" autocomplete="off" />
                                        </div>
                                        <button type="button" class="btn btn-default" id="FitfoodOrderButtonUseDiscountCode">@lang('order_form.useDiscount')</button>
                                    </div>
                                </div>
                                <div class="block">
                                    <div class="box">
                                        <h4>@lang('order_form.cartTotal')</h4>
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <th>@lang('order_form.subTotalPrice')</th>
                                                <td id="FitfoodSubtotalPrice">0</td>
                                            </tr>
                                            <tr>
                                                <th>@lang('order_form.shippingPrice')</th>
                                                <td id="FitfoodShippingPrice">0</td>
                                            </tr>
                                            <tr>
                                                <th>@lang('order_form.extraPrice')</th>
                                                <td id="FitfoodExtraPrice">0</td>
                                            </tr>
                                            <tr>
                                                <th>@lang('order_form.discountPrice')</th>
                                                <td id="FitfoodDiscountPrice">0</td>
                                            </tr>
                                            <tr>
                                                <th>@lang('order_form.total')</th>
                                                <td id="FitfoodTotalMealPackPrice">0</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <button type="submit" id="FitfoodOrderFormSubmitButton" class="btn btn-default btn-large">@lang('order_form.placeOrder')</button>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <input type="hidden" id="FitfoodOrderInputAddressGoogle" name="address_google" />
                            <input type="hidden" id="FitfoodAddressLatitude" name="latitude" />
                            <input type="hidden" id="FitfoodAddressLongitude" name="longitude" />
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

            var map = new google.maps.Map(document.getElementById('FitfoodGoogleMap'), mapOptions);

            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                animation: google.maps.Animation.DROP,
                icon: image,
                draggable: true
            });

            var orderInputAddressElem = document.getElementById('FitfoodOrderInputAddress');
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

                document.getElementById('FitfoodOrderInputAddressGoogle').value = placeName;
                document.getElementById('FitfoodAddressLatitude').value = latlng.lat();
                document.getElementById('FitfoodAddressLongitude').value = latlng.lng();
            }

            function detectDistrict(placeObj)
            {
                if(placeObj.address_components.length >= 5)
                {
                    if(placeObj.address_components[4])
                    {
                        var addressValue = document.getElementById('FitfoodOrderInputAddress').value;

                        if(addressValue.indexOf(placeObj.address_components[4].long_name) == -1)
                            addressValue = addressValue + ', ' + placeObj.address_components[4].long_name;

                        document.getElementById('FitfoodOrderInputAddress').value = addressValue;
                    }
                }
            }
        }

        $(document).ready(function() {

            $('#FitfoodOrderInputPhone').focusout(function() {

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

            $('#FitfoodOrderDropDownDistrict').change(function() {

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

                var shippingTimeElem = $('#FitfoodOrderDropDownShippingTime');

                var totalTempElem = $('#FitfoodTotalMealPackPrice');
                var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                var shippingPriceElem = $('#FitfoodShippingPrice');
                var shippingPriceVal = parseInt(shippingPriceElem.html().split('.').join(''));

                totalTempVal -= shippingPriceVal;

                if(elemVal != '')
                {
                    shippingTimeElem.html('<option value="">* @lang('order_form.time')</option>');

                    for(var key in listDistricts[elemVal].shipping_time)
                        shippingTimeElem.append('<option value="' + key + '">' + listDistricts[elemVal].shipping_time[key] + '</option>');

                    shippingPriceElem.html(formatMoney(listDistricts[elemVal].shipping_price));
                    totalTempVal += parseInt(listDistricts[elemVal].shipping_price);
                }
                else
                {
                    shippingPriceElem.html(0);
                    shippingTimeElem.html('<option value="">* @lang('order_form.time')</option>');
                }

                totalTempElem.html(formatMoney(totalTempVal.toString()));

                removeDiscount();

            });

            $('.FitfoodOrderFormMealPackQuantityInput').each(function() {

                $(this).data('oldVal', $(this).val());

            });

            $('.FitfoodOrderFormMealPackQuantityInput').change(function() {

                var elem = $(this);
                var elemOldVal = elem.data('oldVal');
                var idArr = elem.prop('id').split('_');

                $(this).data('oldVal', elem.val());

                var subtotalTempElem = $('#FitfoodSubtotalPrice');
                var subtotalTempVal = parseInt(subtotalTempElem.html().split('.').join(''));

                var totalTempElem = $('#FitfoodTotalMealPackPrice');
                var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                $('#FitfoodOrderFormTotalPricePerPack_' + idArr[1]).html(formatMoney((parseInt(elem.val()) * parseInt($('#FitfoodOrderFormMealPackPrice_' + idArr[1]).val())).toString()));

                if(elemOldVal == '')
                {
                    subtotalTempVal += parseInt(elem.val()) * parseInt($('#FitfoodOrderFormMealPackPrice_' + idArr[1]).val());
                    totalTempVal += parseInt(elem.val()) * parseInt($('#FitfoodOrderFormMealPackPrice_' + idArr[1]).val());
                }
                else
                {
                    if(elem.val() > elemOldVal)
                    {
                        subtotalTempVal += (parseInt(elem.val()) - parseInt(elemOldVal)) * parseInt($('#FitfoodOrderFormMealPackPrice_' + idArr[1]).val());
                        totalTempVal += (parseInt(elem.val()) - parseInt(elemOldVal)) * parseInt($('#FitfoodOrderFormMealPackPrice_' + idArr[1]).val());
                    }
                    else
                    {
                        subtotalTempVal += (parseInt(elem.val()) - parseInt(elemOldVal)) * parseInt($('#FitfoodOrderFormMealPackPrice_' + idArr[1]).val());
                        totalTempVal -= (parseInt(elemOldVal) - parseInt(elem.val())) * parseInt($('#FitfoodOrderFormMealPackPrice_' + idArr[1]).val());
                    }
                }

                subtotalTempElem.html(formatMoney(subtotalTempVal.toString()));
                totalTempElem.html(formatMoney(totalTempVal.toString()));

                removeDiscount();

                var extraBreakfastElem = $('#FitfoodOrderCheckExtraBreakfast');

                if($('#FitfoodNoBreakfastMainMealPack_' + idArr[1]).length > 0)
                {
                    if(elem.val() > 0)
                    {
                        extraBreakfastElem.removeAttr('disabled');

                        if($('#FitfoodOrderDropDownExtraBreakfastQuantity').prop('disabled') == false)
                        {
                            orderDropDownExtraBreakfastQuantityOldVal = $('#FitfoodOrderDropDownExtraBreakfastQuantity').val();

                            var optionElemsHtml = '';
                            for(var i = 1;i <= elem.val();i ++)
                                optionElemsHtml += '<option value="' + i + '">' + i + '</option>';

                            $('#FitfoodOrderDropDownExtraBreakfastQuantity').html(optionElemsHtml);
                            $('#FitfoodOrderDropDownExtraBreakfastQuantity').trigger('change');
                        }
                    }
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

            });

            var orderDropDownChangeIngredientOldVal;

            $('#FitfoodOrderDropDownChangeIngredient').click(function() {

                orderDropDownChangeIngredientOldVal = $(this).val();

            }).change(function() {

                var totalTempElem = $('#FitfoodTotalMealPackPrice');
                var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                var extraPriceElem = $('#FitfoodExtraPrice');
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

            $('#FitfoodOrderCheckChangeMeal').change(function() {

                var totalTempElem = $('#FitfoodTotalMealPackPrice');
                var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                var extraPriceElem = $('#FitfoodExtraPrice');
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

            $('#FitfoodOrderCheckExtraBreakfast').change(function() {

                var totalTempElem = $('#FitfoodTotalMealPackPrice');
                var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                var extraPriceElem = $('#FitfoodExtraPrice');
                var extraPriceVal = parseInt(extraPriceElem.html().split('.').join(''));

                if($(this).prop('checked') == true)
                {
                    extraPriceVal += <?php echo (App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>;
                    totalTempVal += <?php echo (App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>;

                    var maxExtraBreakfastQuantity = 0;
                    $('.FitfoodOrderFormMealPackQuantityInput').each(function() {

                        var elem = $(this);
                        var idArr = elem.prop('id').split('_');

                        if($('#FitfoodNoBreakfastMainMealPack_' + idArr[1]).length > 0)
                        {
                            if(elem.val() > 0)
                                maxExtraBreakfastQuantity += parseInt(elem.val());
                        }

                    });

                    var optionElemsHtml = '';
                    for(var i = 1;i <= maxExtraBreakfastQuantity;i ++)
                        optionElemsHtml += '<option value="' + i + '">' + i + '</option>';

                    $('#FitfoodOrderDropDownExtraBreakfastQuantity').removeAttr('disabled').html(optionElemsHtml);
                }
                else
                {
                    extraPriceVal -= ($('#FitfoodOrderDropDownExtraBreakfastQuantity').val() * <?php echo (App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>);
                    totalTempVal -= ($('#FitfoodOrderDropDownExtraBreakfastQuantity').val() * <?php echo (App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>);

                    $('#FitfoodOrderDropDownExtraBreakfastQuantity').html('').prop('disabled', 'disabled');
                }

                extraPriceElem.html(formatMoney(extraPriceVal.toString()));
                totalTempElem.html(formatMoney(totalTempVal.toString()));

                removeDiscount();

            });

            var orderDropDownExtraBreakfastQuantityOldVal;

            $('#FitfoodOrderDropDownExtraBreakfastQuantity').click(function() {

                orderDropDownExtraBreakfastQuantityOldVal = $(this).val();

            }).change(function() {

                var totalTempElem = $('#FitfoodTotalMealPackPrice');
                var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                var extraPriceElem = $('#FitfoodExtraPrice');
                var extraPriceVal = parseInt(extraPriceElem.html().split('.').join(''));

                if($(this).val() > orderDropDownExtraBreakfastQuantityOldVal)
                {
                    extraPriceVal += (($(this).val() - orderDropDownExtraBreakfastQuantityOldVal) * <?php echo (App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>);
                    totalTempVal += (($(this).val() - orderDropDownExtraBreakfastQuantityOldVal) * <?php echo (App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>);

                    extraPriceElem.html(formatMoney(extraPriceVal.toString()));
                    totalTempElem.html(formatMoney(totalTempVal.toString()));

                    removeDiscount();
                }
                else if($(this).val() < orderDropDownExtraBreakfastQuantityOldVal)
                {
                    extraPriceVal -= ((orderDropDownExtraBreakfastQuantityOldVal - $(this).val()) * <?php echo (App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>);
                    totalTempVal -= ((orderDropDownExtraBreakfastQuantityOldVal - $(this).val()) * <?php echo (App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>);

                    extraPriceElem.html(formatMoney(extraPriceVal.toString()));
                    totalTempElem.html(formatMoney(totalTempVal.toString()));

                    removeDiscount();
                }

            });

            $('#FitfoodOrderButtonUseDiscountCode').click(function() {

                var discountCode = $('#FitfoodOrderInputDiscountCode').val();

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
                    var totalTempElem = $('#FitfoodTotalMealPackPrice');
                    var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                    var discountPriceElem = $('#FitfoodDiscountPrice');
                    var discountPriceVal = parseInt(discountPriceElem.html().split('.').join(''));

                    var mealPackQuantityList = $('.FitfoodOrderFormMealPackQuantityInput');
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
                        data: '_token={{ csrf_token() }}&code=' + discountCode.trim() + '&phone=' + $('#FitfoodOrderInputPhone').val().trim() + packQuantityPost,
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
                var discountPriceElem = $('#FitfoodDiscountPrice');
                var discountPriceVal = parseInt(discountPriceElem.html().split('.').join(''));

                $('#FitfoodOrderInputDiscountCode').val('');

                if(discountPriceVal != 0)
                {
                    var totalTempElem = $('#FitfoodTotalMealPackPrice');
                    var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                    totalTempVal += discountPriceVal;

                    discountPriceElem.html(0);
                    totalTempElem.html(formatMoney(totalTempVal.toString()));
                }
            }

            $('#FitfoodOrderInputAddress').keydown(function(e) {

                var keyCode = e.keyCode || e.which;
                if(keyCode === 13)
                {
                    e.preventDefault();
                    return false;
                }

            });

            $('.FitfoodPopupImage').magnificPopup({

                type: 'image'

            });

            $('#FitfoodOrderForm').submit(function() {

                $('#FitfoodOrderFormSubmitButton').prop('disabled', 'disabled');
                showLoadingScreen();

                var idArr;
                var mealPackQuantityList = $('.FitfoodOrderFormMealPackQuantityInput');

                var totalMealPack = 0;
                var mealValid = false;

                mealPackQuantityList.each(function() {

                    idArr = $(this).prop('id').split('_');

                    if($(this).val().trim() != '' && !isNaN($(this).val().trim()) && $(this).val().trim() > 0)
                    {
                        if($('#FitfoodMainMealPack_' + idArr[1]).length > 0)
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

                    closeLoadingScreen();
                    $('#FitfoodOrderFormSubmitButton').removeAttr('disabled', 'disabled');
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

                    closeLoadingScreen();
                    $('#FitfoodOrderFormSubmitButton').removeAttr('disabled', 'disabled');
                    return false;
                }

                var inputPhone = $('#FitfoodOrderInputPhone');
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

                    closeLoadingScreen();
                    $('#FitfoodOrderFormSubmitButton').removeAttr('disabled', 'disabled');
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

            @if(!empty($autoAddMealPackId))
            $('#OrderFormMealPackQuantityInput_<?php echo $autoAddMealPackId; ?>').val(1).trigger('change');
            @endif

            @if($showOrderPolicyPopup)
            sweetAlert({

                title: '',
                text: '@lang('order_form.sundayPolicy')',
                allowOutsideClick: true

            });
            @endif

        });

    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap"></script>

@stop