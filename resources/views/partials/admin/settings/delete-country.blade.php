<div class="modal fade" id="deleteCountry_{{ $country->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="deleteCountryLabel">Delete Country</h4>
            </div>
            <div class="body">
                <h4 class="text-danger">Are You Sure you want to delete {{ $country->name }}?</h4>
                <h5 class="text-danger">This action will delete all associated cities, businesses and products and cannot be undone.</h5>
            </div>
            <form action="{{ route('settings.country.delete', ['country' => $country]) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-12">
                            <label for="role_name">Password</label>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Enter Your Password" name="password" value="" required autocomplete="off" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2 list-unstyled"></x-input-error>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-round waves-effect">DELETE</button>
                    <button type="button" class="btn btn-primary btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>
