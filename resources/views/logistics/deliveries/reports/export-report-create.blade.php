@extends('layouts.app')
@section('css')
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
                        <form action="{{ route('deliveries.requests.reports.export.store', ['order_request' => $order_request]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Shipper/Exporter</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Exporter Name" name="exporter" value="{{ old('exporter') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('exporter')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Reference</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Reference" name="reference" value="{{ old('reference') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('reference')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">VAT Number</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="vat_number" value="{{ old('vat_number') }}">
                                        <x-input-error :messages="$errors->get('vat_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Consignee</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="consignee" value="{{ old('consignee') }}">
                                        <x-input-error :messages="$errors->get('consignee')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Notify Party</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Notify Party" name="notify_party" value="{{ old('notify_party') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('notify_party')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Place of Collection</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Place of Collection" name="place_of_collection" value="{{ old('place_of_collection') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('place_of_collection')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Port of Loading</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="port_of_loading" value="{{ old('port_of_loading') }}">
                                        <x-input-error :messages="$errors->get('port_of_loading')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Port of Discharge</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="port_of_discharge" value="{{ old('port_of_discharge') }}">
                                        <x-input-error :messages="$errors->get('port_of_discharge')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Final Destination</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="final_destination" value="{{ old('final_destination') }}">
                                        <x-input-error :messages="$errors->get('final_destination')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Destination Country</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="destination_country" value="{{ old('destination_country') }}">
                                        <x-input-error :messages="$errors->get('destination_country')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Methods of Payment</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="methods_of_payment" value="{{ old('methods_of_payment') }}">
                                        <x-input-error :messages="$errors->get('methods_of_payment')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Mode of Transport</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="mode_of_transport" value="{{ old('mode_of_transport') }}">
                                        <x-input-error :messages="$errors->get('mode_of_transport')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Type of Freight</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="type_of_freight" value="{{ old('type_of_freight') }}">
                                        <x-input-error :messages="$errors->get('type_of_freight')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Number of Packages</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="number_of_packages" value="{{ old('number_of_packages') }}">
                                        <x-input-error :messages="$errors->get('number_of_packages')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Marks and Numbers</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="marks_and_numbers" value="{{ old('marks_and_numbers') }}">
                                        <x-input-error :messages="$errors->get('marks_and_numbers')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Description of goods</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="description_of_goods" value="{{ old('description_of_goods') }}">
                                        <x-input-error :messages="$errors->get('description_of_goods')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Special goods/hazardous, perishable or taint</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="special_goods" value="{{ old('special_goods') }}">
                                        <x-input-error :messages="$errors->get('special_goods')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Gross mass in kgs</label>
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="gross_mass" value="{{ old('gross_mass') }}">
                                        <x-input-error :messages="$errors->get('gross_mass')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Measurement in cm, mm etc</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="measurement" value="{{ old('measurement') }}">
                                        <x-input-error :messages="$errors->get('measurement')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Import Permit Number</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="import_permit_number" value="{{ old('import_permit_number') }}">
                                        <x-input-error :messages="$errors->get('import_permit_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Cargo Insurance</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="cargo_insurance" value="{{ old('cargo_insurance') }}">
                                        <x-input-error :messages="$errors->get('cargo_insurance')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Cargo Value</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="cargo_value" value="{{ old('cargo_value') }}">
                                        <x-input-error :messages="$errors->get('cargo_value')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Incoterms</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="incoterms" value="{{ old('incoterms') }}">
                                        <x-input-error :messages="$errors->get('incoterms')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Customs Export purpose code</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="customs_export_purpose_code" value="{{ old('customs_export_purpose_code') }}">
                                        <x-input-error :messages="$errors->get('customs_export_purpose_code')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Customs Export Number</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="customs_export_number" value="{{ old('customs_export_number') }}">
                                        <x-input-error :messages="$errors->get('customs_export_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Tariff Heading</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="tariff_heading" value="{{ old('tariff_heading') }}">
                                        <x-input-error :messages="$errors->get('tariff_heading')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Special Instructions</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="special_instructions" value="{{ old('special_instructions') }}">
                                        <x-input-error :messages="$errors->get('special_instructions')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Other</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="other" value="{{ old('other') }}">
                                        <x-input-error :messages="$errors->get('other')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-12"></div>
                                @foreach ($documents as $document)
                                    <div class="col-6">
                                        <label for="Max Capacity">{{ $document }}</label>
                                        <div class="form-group">
                                            <input type="file" accept=".pdf" name="documents[{{ $document }}]" class="form-control" id="" />
                                            <x-input-error :messages="$errors->get('documents')" class="mt-2 list-unstyled"></x-input-error>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-12">
                                    I {{ auth()->user()->first_name }} {{ auth()->user()->last_name }} undersign hereby declare that I am authorized to issue and sign this Clearing and Forwarding Instruction for
                                    and on behalf of the Seller. I hereby declare that the information supplied in this form is true and correct and have not ommitted any detail that would be important for this
                                    shipment to be executed according to the wishes of all parties concerning with this cargo.
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="d-flex checkbox">
                                        <input type="checkbox" name="agree" id="agree" class="form-control" required>
                                        <label for="agree">Agree</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-round waves-effect">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
@endpush
@endsection
