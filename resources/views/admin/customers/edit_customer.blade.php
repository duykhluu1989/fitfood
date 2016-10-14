@extends('admin.layouts.main')

@section('title', 'Edit Customer')

@section('header', 'Edit Customer - ' . $customer->customer_id)

@section('content')

    <form method="post" action="{{ url('admin/customer/edit', ['id' => $customer->id]) }}">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ url('admin/customer/detail', ['id' => $customer->id]) }}" class="btn btn-primary btn-outline pull-right">Back</a>
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
                            <input type="text" class="form-control" name="customer[name]" value="{{ $customer->name }}" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Phone</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" name="customer[phone]" value="{{ $customer->phone }}" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Email</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" name="customer[email]" value="{{ $customer->email }}" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Code</h3>
                        </div>
                        <div class="panel-body">
                            <select class="form-control" name="customer[code]" required="required">
                                @foreach(App\Libraries\Util::getCustomerCode() as $value)
                                    @if(strpos($customer->cusotmer_id, $value) !== false)
                                        <option selected="selected" value="<?php echo $value; ?>">{{ $value }}</option>
                                    @else
                                        <option value="<?php echo $value; ?>">{{ $value }}</option>
                                    @endif
                                @endforeach
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
                            <h3 class="panel-title">Address</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" id="OrderInputAddress" class="form-control" name="customer[address]" value="{{ $customer->address }}" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">District</h3>
                        </div>
                        <div class="panel-body">
                            <select class="form-control" name="customer[district]" required="required">
                                @foreach($areas as $area)
                                    @if($area->name == $customer->district)
                                        <option selected="selected" value="<?php echo $area->name; ?>">{{ $area->name }}</option>
                                    @else
                                        <option value="<?php echo $area->name; ?>">{{ $area->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Gender</h3>
                        </div>
                        <div class="panel-body">
                            <select class="form-control" name="customer[gender]" required="required">
                                @foreach(App\Libraries\Util::getGender() as $value => $label)
                                    @if($value == $customer->gender)
                                        <option selected="selected" value="<?php echo $value; ?>">{{ $label }}</option>
                                    @else
                                        <option value="<?php echo $value; ?>">{{ $label }}</option>
                                    @endif
                                @endforeach
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
                            <input type="text" id="OrderInputAddressGoogle" class="form-control" name="customer[address_google]" value="{{ $customer->address_google }}" readonly="readonly" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Latitude</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" id="AddressLatitude" class="form-control" name="customer[latitude]" value="{{ $customer->latitude }}" readonly="readonly" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Longitude</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" id="AddressLongitude" class="form-control" name="customer[longitude]" value="{{ $customer->longitude }}" readonly="readonly" required="required" />
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
            var lat = {{ $customer->latitude }};
            var lng = {{ $customer->longitude }};
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

            infoWindow.setContent('{{ $customer->address_google }}');
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