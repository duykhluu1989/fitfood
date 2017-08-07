@extends('beta.layouts.main')

@section('content')

    @include('beta.layouts.partials.menu')

    @include('beta.layouts.partials.header', ['banner' => asset('assets/images/page-header/order.jpg'), 'title' => 'Order Trial'])

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
                            <h2>Order Trial form</h2>
                        </div>
                        <form role="form" action="{{ url('trial') }}" method="post" id="FitfoodOrderForm">
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
                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                        <input type="text" class="form-control input-lg" id="FitfoodOrderInputAddress" name="address" placeholder="* @lang('order_form.address')" autocomplete="off" required="required" />
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <input type="text" class="form-control input-lg DatePicker" name="shipping_date" placeholder="* @lang('order_form.date')" autocomplete="off" required="required" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-xs-12">
                                        <select class="form-control input-lg" id="FitfoodOrderDropDownDistrict" name="district" required="required">
                                            <option value="">* @lang('order_form.districtNoFee')</option>
                                            @foreach($areas as $area)
                                                <option value="{{ $area->id }}">{{ $area->name }}</option>
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
                                        <input type="text" class="form-control input-lg" name="discount_code" autocomplete="off" placeholder="* @lang('order_form.inputDiscount')" required="required" />
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                        <textarea class="form-control" name="note" placeholder="@lang('order_form.trialNote')"></textarea>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" id="FitfoodOrderFormSubmitButton" class="btn btn-default btn-large">@lang('order_form.placeOrder')</button>
                                </div>
                                <div class="form-group">
                                    <div id="FitfoodGoogleMap"></div>
                                    <div class="clearfix"></div>
                                </div>
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

            $('.DatePicker').datepicker({

                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                showOtherMonths: true,
                selectOtherMonths: true,
                minDate: 3,
                beforeShowDay: function(date) {
                    var day = date.getDay();
                    return [day != 0 && day != 6, ''];
                }

            });

            $('#FitfoodOrderInputPhone').focusout(function() {

                var elem = $(this);
                var elemVal = elem.val().trim();

                var pattern = /^0[0-9]{7,10}$/;

                if(elemVal == '' || !pattern.test(elemVal))
                    elem.parent().addClass('has-error');
                else
                    elem.parent().removeClass('has-error');

            });

            $('#FitfoodOrderDropDownDistrict').change(function() {

                var elemVal = $(this).val().trim();
                var listDistricts = {
                    @foreach($areas as $area)
                    '{{ $area->id }}': {
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

                if(elemVal != '')
                {
                    shippingTimeElem.html('<option value="">* @lang('order_form.time')</option>');

                    for(var key in listDistricts[elemVal].shipping_time)
                        shippingTimeElem.append('<option value="' + key + '">' + listDistricts[elemVal].shipping_time[key] + '</option>');
                }
                else
                    shippingTimeElem.html('<option value="">* @lang('order_form.time')</option>');

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

        });

    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap"></script>

@stop