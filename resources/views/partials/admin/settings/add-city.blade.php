<div class="modal fade" id="addCity_{{ $country->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="addCityLabel">Add City</h4>
            </div>
            <form action="{{ route('settings.city.store', ['country' => $country]) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-12">
                            <label for="role_name">Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Enter City Name" name="name" required autocomplete="off" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2 list-unstyled"></x-input-error>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="role_name">Latitude</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Enter City Latitudinal Coordinates" name="latitude" autocomplete="off" />
                                <x-input-error :messages="$errors->get('latitude')" class="mt-2 list-unstyled"></x-input-error>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="role_name">Longitude</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Enter City Longitudinal" name="longitude" autocomplete="off" />
                                <x-input-error :messages="$errors->get('longitude')" class="mt-2 list-unstyled"></x-input-error>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-round waves-effect">SAVE</button>
                    <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>
