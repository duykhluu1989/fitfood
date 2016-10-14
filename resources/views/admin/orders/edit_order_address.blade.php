@extends('admin.layouts.main')

@section('title', 'Edit Order Address')

@section('header', 'Edit Order Address - ' . $order->order_id)

@section('content')

    <form method="post" action="{{ url('admin/order/address/edit', ['id' => $order->id]) }}">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ url('admin/order/detail', ['id' => $order->id]) }}" class="btn btn-primary btn-outline pull-right">Back</a>
                </div>
            </div>
        </div>

        @if(isset($errors))
            @include('admin.layouts.partials.form_error', ['errors' => $errors])
        @endif

        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Name</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" name="address[name]" value="{{ $order->orderAddress->name }}" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Phone</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" name="address[phone]" value="{{ $order->customer->phone }}" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Email</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" name="address[email]" value="{{ $order->orderAddress->email }}" required="required" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Address</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" id="OrderInputAddress" class="form-control" name="address[address]" value="{{ $order->orderAddress->address }}" required="required" />
                        </div>
                    </div>
                </div>
                <?php
                $currentArea = null;
                ?>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">District</h3>
                        </div>
                        <div class="panel-body">
                            <select class="form-control" id="OrderDropDownDistrict" name="address[district]" required="required">
                                @foreach($areas as $area)
                                    @if($area->name == $order->orderAddress->district)
                                        <?php
                                        $currentArea = $area;
                                        ?>
                                        <option selected="selected" value="<?php echo $area->name; ?>">{{ $area->name . (!empty($area->shipping_price) ? ' (Ship: ' . App\Libraries\Util::formatMoney($area->shipping_price) . ')' : '') }}</option>
                                    @else
                                        <option value="<?php echo $area->name; ?>">{{ $area->name . (!empty($area->shipping_price) ? ' (Ship: ' . App\Libraries\Util::formatMoney($area->shipping_price) . ')' : '') }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Shipping Time</h3>
                        </div>
                        <div class="panel-body">
                            <select class="form-control" id="OrderDropDownShippingTime" name="address[shipping_time]" required="required">
                                @if(!empty($currentArea))
                                    <?php
                                    $shippingTimes = json_decode($currentArea->shipping_time, true);
                                    ?>
                                    @foreach($shippingTimes as $value => $label)
                                        @if($value == $order->shipping_time)
                                            <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Address Google</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" id="OrderInputAddressGoogle" class="form-control" name="address[address_google]" value="{{ $order->orderAddress->address_google }}" readonly="readonly" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Latitude</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" id="AddressLatitude" class="form-control" name="address[latitude]" value="{{ $order->orderAddress->latitude }}" readonly="readonly" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Longitude</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" id="AddressLongitude" class="form-control" name="address[longitude]" value="{{ $order->orderAddress->longitude }}" readonly="readonly" required="required" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

    </form>

    <div class="col-sm-12" id="GoogleMap" style="height: 500px"></div>

@stop

@section('script')

    <script type="text/javascript">

        function initMap()
        {
            var lat = {{ $order->orderAddress->latitude }};
            var lng = {{ $order->orderAddress->longitude }};
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

            infoWindow.setContent('{{ $order->orderAddress->address_google }}');
            infoWindow.open(map, marker);

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

            $('#OrderDropDownDistrict').change(function() {

                var elemVal = $(this).val().trim();
                var listDistricts = {
                    @foreach($areas as $area)
                    '<?php echo $area->name; ?>': {
                        'shipping_time': {
                            <?php $shippingTimes = json_decode($area->shipping_time, true); ?>
                            @foreach($shippingTimes as $value => $label)
                                '{{ $value }}': '{{ $label }}',
                        @endforeach
                    }
                    },
                    @endforeach
                };

                var shippingTimeElem = $('#OrderDropDownShippingTime');
                var shippingTimeElemVal = shippingTimeElem.val();

                shippingTimeElem.html('<option value=""></option>');

                for(var key in listDistricts[elemVal].shipping_time)
                {
                    if(key == shippingTimeElemVal)
                        shippingTimeElem.append('<option selected="selected" value="' + key + '">' + listDistricts[elemVal].shipping_time[key] + '</option>');
                    else
                        shippingTimeElem.append('<option value="' + key + '">' + listDistricts[elemVal].shipping_time[key] + '</option>');
                }

            });

            $('#OrderInputAddress').keydown(function(e) {

                var keyCode = e.keyCode || e.which;
                if(keyCode === 13)
                {
                    e.preventDefault();
                    return false;
                }

            });

        });

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap"></script>

@stop