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
                                                <option value="{{ $area->id }}">{{ $area->name . (!empty($area->shipping_price) ? ' (Ship: ' . App\Libraries\Util::formatMoney($area->shipping_price * $normalMenuDays / 5) . ')' : '') . ' ' . \App\Libraries\Util::getValueByLocale($area, 'note') }}</option>
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
                                        @if(!empty($mealPack->breakfast) || !empty($mealPack->lunch) || !empty($mealPack->dinner))
                                            <tr>
                                                <td>
                                                    @if(!empty($mealPack->image_src))
                                                        <a class="FitfoodPopupImage" href="{{ $mealPack->image_src }}">
                                                    @endif
                                                            <strong id="FitfoodOrderFormMealPackName_{{ $mealPack->id }}">
                                                                @if(App::getLocale() == 'en' && !empty($mealPack->name_en))
                                                                    {{ $mealPack->name_en }}
                                                                @else
                                                                    {{ $mealPack->name }}
                                                                @endif
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
                                                    {{ App\Libraries\Util::formatMoney($mealPack->price * $normalMenuDays / 5) }}
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-number" data-type="minus" data-field="mealPack[{{ $mealPack->id }}]" disabled="disabled">
                                                                <i class="fa fa-angle-left" aria-hidden="true"></i>
                                                            </button>
                                                        </span>
                                                        <input type="text" id="OrderFormMealPackQuantityInput_{{ $mealPack->id }}" name="mealPack[{{ $mealPack->id }}]" value="0" min="0" max="5"
                                                            class="form-control input-number FitfoodOrderFormMealPackQuantityInput FitfoodMainMealPack" />
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-number" data-type="plus" data-field="mealPack[{{ $mealPack->id }}]">
                                                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                            </button>
                                                        </span>
                                                        <input type="hidden" id="FitfoodOrderFormMealPackPrice_{{ $mealPack->id }}" value="{{ $mealPack->price * $normalMenuDays / 5 }}" />
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
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                <h5>@lang('order_form.chooseAddon')</h5>
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
                                        @if(empty($mealPack->breakfast) && empty($mealPack->lunch) && empty($mealPack->dinner))
                                            <tr>
                                                <td>
                                                    @if(!empty($mealPack->image_src))
                                                        <a class="FitfoodPopupImage" href="{{ $mealPack->image_src }}">
                                                            @endif
                                                            <strong id="FitfoodOrderFormMealPackName_{{ $mealPack->id }}">
                                                                @if(App::getLocale() == 'en' && !empty($mealPack->name_en))
                                                                    {{ $mealPack->name_en }}
                                                                @else
                                                                    {{ $mealPack->name }}
                                                                @endif
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
                                                    {{ App\Libraries\Util::formatMoney($mealPack->price) }}
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-number" data-type="minus" data-field="mealPack[{{ $mealPack->id }}]" disabled="disabled">
                                                                <i class="fa fa-angle-left" aria-hidden="true"></i>
                                                            </button>
                                                        </span>
                                                        <input type="text" id="OrderFormMealPackQuantityInput_{{ $mealPack->id }}" name="mealPack[{{ $mealPack->id }}]" value="0" min="0" max="5"
                                                               class="form-control input-number FitfoodOrderFormMealPackQuantityInput" />
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-number" data-type="plus" data-field="mealPack[{{ $mealPack->id }}]">
                                                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                            </button>
                                                        </span>
                                                        <input type="hidden" id="FitfoodOrderFormMealPackPrice_{{ $mealPack->id }}" value="{{ $mealPack->price }}" />
                                                    </div>
                                                </td>
                                                <td id="FitfoodOrderFormTotalPricePerPack_{{ $mealPack->id }}">0</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="frm-checkout">
                                <div class="block">
                                    <div class="box">
                                        <h4>@lang('order_form.request')</h4>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="FitfoodOrderCheckChangeIngredient" disabled="disabled" />
                                                @lang('order_form.changeIngredient')
                                                <span>
                                                    <?php echo App\Libraries\Util::formatMoney(App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE); ?>/@lang('order_form.package')
                                                </span>
                                            </label>
                                            <i class="fa fa-info-circle fa-fw" data-toggle="tooltip" title="@lang('order_form.noteChangeIngredient')"></i>
                                        </div>
                                        <table class="table-bordered table-striped table-condensed" id="FiffoodOrderChangeIngredientDetail" style="display: none">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                @foreach(App\Libraries\Util::getRequestChangeIngredient(null, App::getLocale()) as $label)
                                                    <th>{{ str_replace('Không', 'Ko', $label) }}</th>
                                                @endforeach
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="FitfoodOrderCheckChangeMeal" disabled="disabled" />
                                                <?php echo (App::getLocale() == 'en' ? App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL_EN : App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL); ?>
                                                <span>
                                                    <?php echo App\Libraries\Util::formatMoney(App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_PRICE); ?>/@lang('order_form.package')
                                                </span>
                                            </label>
                                        </div>
                                        <table class="table-bordered table-striped table-condensed" id="FiffoodOrderChangeMealDetail" style="display: none">
                                            <tbody></tbody>
                                        </table>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="FitfoodOrderCheckExtraBreakfast" name="extra_breakfast" value="<?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_VALUE; ?>" disabled="disabled" />
                                                <?php echo (App::getLocale() == 'en' ? App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL_EN : App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL); ?>
                                                <span>
                                                    <?php echo App\Libraries\Util::formatMoney(App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>/@lang('order_form.package')
                                                </span>
                                            </label>
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
                                        <div class="form-group">
                                            <div class="col-lg-12 col-md-12 col-xs-12">
                                                <textarea class="form-control" name="note" placeholder="@lang('order_form.note')"></textarea>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-12 col-md-12 col-xs-12">
                                                <textarea class="form-control" name="ship_note" placeholder="@lang('order_form.shipNote')"></textarea>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
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
                                        <label>@lang('order_form.noCallNote')</label>
                                        <button type="submit" id="FitfoodOrderFormSubmitButton" class="btn btn-default btn-large">@lang('order_form.placeOrder')</button>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <input type="hidden" id="FitfoodOrderInputAddressGoogle" name="address_google" />
                            <input type="hidden" id="FitfoodAddressLatitude" name="latitude" />
                            <input type="hidden" id="FitfoodAddressLongitude" name="longitude" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.layouts.partials.loading')

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1665387320368867', {
            em: 'insert_email_variable,'
        });
        fbq('track', 'OrderPage');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1665387320368867&ev=OrderPage&noscript=1" />
    </noscript>
    <!-- DO NOT MODIFY -->
    <!-- End Facebook Pixel Code -->

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

                    sweetAlert({

                        title: '',
                        text: '@lang('order_form.districtMessage')',
                        allowOutsideClick: true

                    });
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

            }).change(function() {

                var elem = $(this);
                var elemOldVal = elem.data('oldVal');
                var idArr = elem.prop('id').split('_');

                $(this).data('oldVal', elem.val());

                var subtotalTempElem = $('#FitfoodSubtotalPrice');
                var subtotalTempVal = parseInt(subtotalTempElem.html().split('.').join(''));

                var totalTempElem = $('#FitfoodTotalMealPackPrice');
                var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                var mealPackPriceElem = $('#FitfoodOrderFormMealPackPrice_' + idArr[1]);

                $('#FitfoodOrderFormTotalPricePerPack_' + idArr[1]).html(formatMoney((parseInt(elem.val()) * parseInt(mealPackPriceElem.val())).toString()));

                if(elemOldVal == '')
                {
                    subtotalTempVal += parseInt(elem.val()) * parseInt(mealPackPriceElem.val());
                    totalTempVal += parseInt(elem.val()) * parseInt(mealPackPriceElem.val());
                }
                else
                {
                    if(elem.val() > elemOldVal)
                    {
                        subtotalTempVal += (parseInt(elem.val()) - parseInt(elemOldVal)) * parseInt(mealPackPriceElem.val());
                        totalTempVal += (parseInt(elem.val()) - parseInt(elemOldVal)) * parseInt(mealPackPriceElem.val());
                    }
                    else
                    {
                        subtotalTempVal += (parseInt(elem.val()) - parseInt(elemOldVal)) * parseInt(mealPackPriceElem.val());
                        totalTempVal -= (parseInt(elemOldVal) - parseInt(elem.val())) * parseInt(mealPackPriceElem.val());
                    }
                }

                subtotalTempElem.html(formatMoney(subtotalTempVal.toString()));
                totalTempElem.html(formatMoney(totalTempVal.toString()));

                removeDiscount();

                var extraBreakfastElem = $('#FitfoodOrderCheckExtraBreakfast');
                var extraBreakfastQuantityElem = $('#FitfoodOrderDropDownExtraBreakfastQuantity');

                if($('#FitfoodNoBreakfastMainMealPack_' + idArr[1]).length > 0)
                {
                    if(elem.val() > 0)
                    {
                        extraBreakfastElem.removeAttr('disabled');

                        if(extraBreakfastQuantityElem.prop('disabled') == false)
                        {
                            orderDropDownExtraBreakfastQuantityOldVal = extraBreakfastQuantityElem.val();

                            var optionElemsHtml = '';
                            for(var i = 1;i <= elem.val();i ++)
                                optionElemsHtml += '<option value="' + i + '">' + i + '</option>';

                            extraBreakfastQuantityElem.html(optionElemsHtml);
                            extraBreakfastQuantityElem.trigger('change');
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

                var totalMainMealPack = 0;
                var idArrTemp;

                var extraChangeIngredientTableBodyHtml = '';
                var extraChangeMealTableBodyHtml = '';

                var rowNo = 1;

                $('.FitfoodMainMealPack').each(function() {

                    idArrTemp = $(this).prop('id').split('_');

                    if($(this).val().trim() != '' && !isNaN($(this).val().trim()) && $(this).val().trim() > 0)
                    {
                        totalMainMealPack += parseInt($(this).val().trim());

                        for(var i = 1;i <= $(this).val().trim();i ++)
                        {
                            var mealPackNameElem = $('#FitfoodOrderFormMealPackName_' + idArrTemp[1]);

                            extraChangeIngredientTableBodyHtml += '' +
                                '<tr>' +
                                '<th>' + mealPackNameElem.html() + '</th>' +
                                @foreach(App\Libraries\Util::getRequestChangeIngredient(null, App::getLocale()) as $value => $label)
                                    '<td><input type="checkbox" name="change_ingredient[' + rowNo + '][{{ $value }}]" value="{{ $value }}" class="FiffoodOrderCheckChangeIngredientDetail" /></th>' +
                                @endforeach
                                '</tr>' +
                            '';

                            extraChangeMealTableBodyHtml += '' +
                                '<tr>' +
                                '<th>' + mealPackNameElem.html() + '</th>' +
                                '<td><input type="checkbox" name="change_meal_course[' + rowNo + ']" value="{{ App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_VALUE }}" class="FiffoodOrderCheckChangeMealDetail" /></th>' +
                                '</tr>' +
                            '';

                            rowNo ++;
                        }
                    }

                });

                var extraChangeIngredientElem = $('#FitfoodOrderCheckChangeIngredient');
                var extraChangeMealElem = $('#FitfoodOrderCheckChangeMeal');

                if(extraChangeIngredientElem.prop('checked') == true)
                    removeChangeIngredientPrice();

                if(extraChangeMealElem.prop('checked') == true)
                    removeChangeMealPrice();

                $('#FiffoodOrderChangeIngredientDetail').find('tbody').first().html(extraChangeIngredientTableBodyHtml);
                $('#FiffoodOrderChangeMealDetail').find('tbody').first().html(extraChangeMealTableBodyHtml);

                if(totalMainMealPack > 0)
                {
                    extraChangeIngredientElem.removeAttr('disabled');
                    extraChangeMealElem.removeAttr('disabled');
                }
                else
                {
                    if(extraChangeIngredientElem.prop('checked') == true)
                    {
                        extraChangeIngredientElem.removeAttr('checked');
                        extraChangeIngredientElem.trigger('change');
                    }

                    if(extraChangeMealElem.prop('checked') == true)
                    {
                        extraChangeMealElem.removeAttr('checked');
                        extraChangeMealElem.trigger('change');
                    }

                    extraChangeIngredientElem.prop('disabled', 'disabled');
                    extraChangeMealElem.prop('disabled', 'disabled');
                }

            });

            $('#FitfoodOrderCheckChangeIngredient').change(function() {

                var extraChangeIngredientTableDetailElem = $('#FiffoodOrderChangeIngredientDetail');

                if($(this).prop('checked') == true)
                    extraChangeIngredientTableDetailElem.show();
                else
                {
                    removeChangeIngredientPrice();

                    extraChangeIngredientTableDetailElem.hide();
                }

            });

            function removeChangeIngredientPrice()
            {
                $('#FiffoodOrderChangeIngredientDetail').each(function() {

                    $(this).find('input:checked').each(function() {

                        $(this).removeAttr('checked');
                        $(this).trigger('change');

                    });

                });
            }

            $('#FiffoodOrderChangeIngredientDetail').on('change', 'input', function() {

                if($(this).hasClass('FiffoodOrderCheckChangeIngredientDetail'))
                {
                    var totalTempElem = $('#FitfoodTotalMealPackPrice');
                    var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                    var extraPriceElem = $('#FitfoodExtraPrice');
                    var extraPriceVal = parseInt(extraPriceElem.html().split('.').join(''));

                    var checkedInRow = $(this).parent().parent().find('input:checked').length;

                    if($(this).prop('checked') == true)
                    {
                        if(checkedInRow == 1)
                        {
                            extraPriceVal += <?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE; ?>;
                            totalTempVal += <?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE; ?>;
                        }
                        else if(checkedInRow == 2)
                            $(this).parent().parent().find('input:not(:checked)').prop('disabled', 'disabled');
                    }
                    else
                    {
                        if(checkedInRow == 1)
                            $(this).parent().parent().find('input:not(:checked)').removeAttr('disabled');
                        else if(checkedInRow == 0)
                        {
                            extraPriceVal -= <?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE; ?>;
                            totalTempVal -= <?php echo App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE; ?>;
                        }
                    }

                    extraPriceElem.html(formatMoney(extraPriceVal.toString()));
                    totalTempElem.html(formatMoney(totalTempVal.toString()));

                    removeDiscount();
                }

            });

            $('#FitfoodOrderCheckChangeMeal').change(function() {

                var extraChangeMealTableDetailElem = $('#FiffoodOrderChangeMealDetail');

                if($(this).prop('checked') == true)
                {
                    if(extraChangeMealTableDetailElem.find('input').length == 1)
                        extraChangeMealTableDetailElem.find('input').first().prop('checked', 'checked').trigger('change');

                    extraChangeMealTableDetailElem.show();
                }
                else
                {
                    removeChangeMealPrice();

                    extraChangeMealTableDetailElem.hide();
                }

            });

            function removeChangeMealPrice()
            {
                $('#FiffoodOrderChangeMealDetail').each(function() {

                    $(this).find('input:checked').each(function() {

                        $(this).removeAttr('checked');
                        $(this).trigger('change');

                    });

                });
            }

            $('#FiffoodOrderChangeMealDetail').on('change', 'input', function() {

                if($(this).hasClass('FiffoodOrderCheckChangeMealDetail'))
                {
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
                }

            });

            $('#FitfoodOrderCheckExtraBreakfast').change(function() {

                var totalTempElem = $('#FitfoodTotalMealPackPrice');
                var totalTempVal = parseInt(totalTempElem.html().split('.').join(''));

                var extraPriceElem = $('#FitfoodExtraPrice');
                var extraPriceVal = parseInt(extraPriceElem.html().split('.').join(''));

                var extraBreakfastQuantityElem = $('#FitfoodOrderDropDownExtraBreakfastQuantity');

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

                    extraBreakfastQuantityElem.removeAttr('disabled').html(optionElemsHtml);
                }
                else
                {
                    extraPriceVal -= (extraBreakfastQuantityElem.val() * <?php echo (App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>);
                    totalTempVal -= (extraBreakfastQuantityElem.val() * <?php echo (App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE * $normalMenuDays / 5); ?>);

                    extraBreakfastQuantityElem.html('').prop('disabled', 'disabled');
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

            $('.FitfoodPopupImage').magnificPopup({

                type: 'image'

            });

            $('#FitfoodOrderForm').keydown(function(e) {

                var keyCode = e.keyCode || e.which;
                if(keyCode === 13)
                {
                    e.preventDefault();
                    return false;
                }

            }).submit(function() {

                var orderFormSubmitElem = $('#FitfoodOrderFormSubmitButton');

                orderFormSubmitElem.prop('disabled', 'disabled');
                showLoadingScreen();

                var mealPackQuantityList = $('.FitfoodOrderFormMealPackQuantityInput');

                var totalMealPack = 0;
                var mealValid = false;

                mealPackQuantityList.each(function() {

                    if($(this).val().trim() != '' && !isNaN($(this).val().trim()) && $(this).val().trim() > 0)
                    {
                        if($(this).hasClass('FitfoodMainMealPack'))
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
                    orderFormSubmitElem.removeAttr('disabled', 'disabled');
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
                    orderFormSubmitElem.removeAttr('disabled', 'disabled');
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
                    orderFormSubmitElem.removeAttr('disabled', 'disabled');
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
                text: '<?php echo ($showOrderPolicyPopup == 1 ? trans('order_form.sundayPolicy') : trans('order_form.mondayPolicy')); ?>',
                allowOutsideClick: true

            });
            @endif

        });

    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap"></script>

@stop