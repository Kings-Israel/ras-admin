@extends('layouts.app')
@section('css')
<style>
    #gmap_markers {
        height: 380px;
    }
    #super{
        vertical-align:super;
        font-size: smaller;
    }
</style>
@endsection
@section('content')
<section class="content home">
    <div class="container-fluid">
        <x-breadcrumbs :page="$page" :items="$breadcrumbs"></x-breadcrumbs>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>{{ Str::title($page) }}</strong></h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('warehouses.store') }}" method="POST">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-6">
                                    <label for="name">Name</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Name" name="name" value="{{ old('name') }}" required autocomplete="off" />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="Max Capacity">Max Capacity (m<span id="super">3</span>)</label>
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="max_capacity" :value="old('max_capacity')" min="1">
                                        <x-input-error :messages="$errors->get('max_capacity')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="Max Capacity">Price (per m<span id="super">3</span> in USD$)</label>
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="price" :value="old('price')" min="1">
                                        <x-input-error :messages="$errors->get('price')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                {{-- <div class="col-6">
                                    <label for="country">Country</label>
                                    <select name="country_id" class="form-control show-tick" onchange="getDetails()" id="country">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" @if(old('country_id') == $country->id) selected @endif data-cities="{{ $country->cities }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('country_id')" class="mt-2 list-unstyled"></x-input-error>
                                </div>
                                <div class="col-6">
                                    <label for="city">City</label>
                                    <div class="form-group">
                                        <select name="city_id" id="city_id" class="form-control show-tick">
                                            <option value="">Select City</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('city_id')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div> --}}
                            </div>
                            <br>
                            <h6 class="header">Select Manager or Add New Manager</h6>
                            <div class="row clearfix">
                                <div class="col-6">
                                    <label for="manager">Select Manager</label>
                                    <div class="form-group">
                                        <select name="users[]" id="user" class="form-control" multiple>
                                            <option value="">Select Manager</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('user_id')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="header">Add New Manager</div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <label for="First Name">First Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                                                <x-input-error :messages="$errors->get('first_name')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="Last Name">Last Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                                                <x-input-error :messages="$errors->get('last_name')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="email">Email</label>
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                                <x-input-error :messages="$errors->get('email')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <label for="Phone Number">Phone Number</label>
                                            <div class="form-group">
                                                <input type="tel" class="form-control" name="phone_number" value="{{ old('phone_number') }}">
                                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2 list-unstyled"></x-input-error>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="body">
                                <label for="Warehouse_location">Select Location</label>
                                <input id="place_id" type="hidden" name="place_id" :value="old('place_id')">
                                <input type="text" name="warehouse_location" id="pac-input" placeholder="Search location here" class="form-control mb-2">
                                <div id="gmap_markers" class="gmap"></div>
                                <x-input-error :messages="$errors->get('place_id')" class="mt-2 list-unstyled"></x-input-error>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-round waves-effect">SAVE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script>
    // function getDetails() {
    //     let cities = $('#country').find(':selected').data('cities');
    //     let cityOptions = document.getElementById('city_id')
    //     while (cityOptions.options.length) {
    //         cityOptions.remove(0);
    //     }
    //     var city = new Option('Select City', '');
    //     cityOptions.options.add(city);
    //     if (cities) {
    //         cities.forEach(city => {
    //             var city_option = new Option(city.name, city.id);
    //             cityOptions.options.add(city_option);
    //         })
    //     }
    // }

    function placeMarker(location) {
        if (marker) {
            marker.setPosition(location);
        } else {
            marker = new google.maps.Marker({
                position: location,
                map: mapInstance
            });
        }
    }

    function initMap() {
        var map = new google.maps.Map(document.getElementById('gmap_markers'), {
            center: {lat: -1.270104, lng: 36.80814},
            zoom: 3
        });
        var input = document.getElementById('pac-input');

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();

            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }

            document.getElementById('place_id').value = place.place_id

            map.setCenter(place.geometry.location);
            map.setZoom(17);

            placeMarker(place.geometry.location);
            marker.setVisible(true);
        });

        geocoder = new google.maps.Geocoder;

        google.maps.event.addListener(map, 'click', function(event) {
            geocoder.geocode({
                'location': event.latLng
            }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    document.getElementById('place_id').value = results[0].place_id
                } else {
                    console.log('No results found');
                }
                } else {
                console.log('Geocoder failed due to: ' + status);
                }
            });
            placeMarker(event.latLng);
        });
   }
</script>
<script src="{!! config('services.maps.key') !!}" async defer></script>
@endpush
@endsection
