<div class="modal fade" id="editDocument_{{ $document->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="editDocumentLabel">Edit Document</h4>
            </div>
            <form class="body" action="{{ route('settings.document.update', ['document' => $document]) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <label for="role_name">Document Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Name" name="document_name" value="{{ $document->name }}" required autocomplete="off" />
                                <x-input-error :messages="$errors->get('document_name')" class="mt-2 list-unstyled"></x-input-error>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="expiry_date_required_label">Expiry Date Required</label>
                            <div class="form-group">
                                <div class="radio inlineblock m-r-20">
                                    <input type="radio" name="expiry_date_required" id="yes_{{ $document->id }}" class="with-gap" value="true" @if($document->requires_expiry_date) checked @endif>
                                    <label for="yes_{{ $document->id }}">Yes</label>
                                </div>
                                <div class="radio inlineblock">
                                    <input type="radio" name="expiry_date_required" id="no_{{ $document->id }}" class="with-gap" value="false" @if(!$document->requires_expiry_date) checked @endif>
                                    <label for="no_{{ $document->id }}">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <label for="role_name">Select Countries where document is required</label>
                        @php($selected_countries = $document->countries->count() > 0 ? $document->countries->pluck('id')->toArray() : [])
                        <select name="updated_countries[]" class="form-control show-tick" id="update_countries" multiple>
                            <option value="all" @if(count($selected_countries) === 0) selected @endif>All</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @if(in_array($country->id, $selected_countries)) selected @endif>{{ $country->name }}</option>
                            @endforeach
                        </select>
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
