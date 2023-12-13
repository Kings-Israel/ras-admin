<div class="modal fade" id="editCity_{{ $city->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="editCityLabel">Edit City</h4>
            </div>
            <form action="{{ route('settings.city.update', ['city' => $city]) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-12">
                            <label for="role_name">Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Enter City Name" name="name" value="{{ $city->name }}" required autocomplete="off" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2 list-unstyled"></x-input-error>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="role_name">Latitude</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Enter City Latitudinal Coordinates" name="latitude" value="{{ $city->latitude }}" autocomplete="off" />
                                <x-input-error :messages="$errors->get('latitude')" class="mt-2 list-unstyled"></x-input-error>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="role_name">Longitude</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Enter City Longitudinal Coordinates" name="longitude" value="{{ $city->longitude }}" autocomplete="off" />
                                <x-input-error :messages="$errors->get('longitude')" class="mt-2 list-unstyled"></x-input-error>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-round waves-effect">SAVE CHANGES</button>
                    <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>
