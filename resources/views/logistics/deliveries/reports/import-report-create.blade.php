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
                        <form action="{{ route('deliveries.requests.reports.import.store', ['order_request' => $order_request]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Importer</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Importer Name" name="importer" value="{{ old('importer') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('importer')" class="mt-2 list-unstyled"></x-input-error>
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
                                    <label for="Max Capacity">Customs Code</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="customs_code" value="{{ old('customs_code') }}">
                                        <x-input-error :messages="$errors->get('customs_code')" class="mt-2 list-unstyled"></x-input-error>
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
                                    <label for="name">Supplier</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Supplier" name="supplier" value="{{ old('supplier') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('supplier')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Transport Mode</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Transport Mode" name="transport_mode" value="{{ old('transport_mode') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('transport_mode')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">E.T.A</label>
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="eta" value="{{ old('eta') }}">
                                        <x-input-error :messages="$errors->get('eta')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Transport Document Number</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="transport_document_number" value="{{ old('transport_document_number') }}">
                                        <x-input-error :messages="$errors->get('transport_document_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Transport Document Date</label>
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="eta" value="{{ old('eta') }}">
                                        <x-input-error :messages="$errors->get('eta')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Shipment Reference Number</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="shipment_reference_number" value="{{ old('shipment_reference_number') }}">
                                        <x-input-error :messages="$errors->get('shipment_reference_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Invoice Number</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="invoice_number" value="{{ old('invoice_number') }}">
                                        <x-input-error :messages="$errors->get('invoice_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Invoice Date</label>
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="invoice_date" value="{{ old('invoice_date') }}">
                                        <x-input-error :messages="$errors->get('invoice_date')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Port of Entry</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="port_of_entry" value="{{ old('port_of_entry') }}">
                                        <x-input-error :messages="$errors->get('port_of_entry')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Customs Purpose Code</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="customs_purpose_code" value="{{ old('customs_purpose_code') }}">
                                        <x-input-error :messages="$errors->get('customs_purpose_code')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Destination Code</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="destination_code" value="{{ old('destination_code') }}">
                                        <x-input-error :messages="$errors->get('destination_code')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Tariff Determination</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="tariff_determination" value="{{ old('tariff_determination') }}">
                                        <x-input-error :messages="$errors->get('tariff_determination')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Customs Valuation Code</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="customs_valuation_code" value="{{ old('customs_valuation_code') }}">
                                        <x-input-error :messages="$errors->get('customs_valuation_code')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Customs Valuation Method</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="customs_valuation_method" value="{{ old('customs_valuation_method') }}">
                                        <x-input-error :messages="$errors->get('customs_valuation_method')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Customs Value FOB / SOB Date</label>
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="customs_value_date" value="{{ old('customs_value_date') }}">
                                        <x-input-error :messages="$errors->get('customs_value_date')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Number of Packages</label>
                                    <div class="form-group">
                                        <input type="number" min="0" class="form-control" name="number_of_packages" value="{{ old('number_of_packages') }}">
                                        <x-input-error :messages="$errors->get('number_of_packages')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Special goods / hazardous, perishable or taint</label>
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
                                    <label for="Max Capacity">Incoterms</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="incoterms" value="{{ old('incoterms') }}">
                                        <x-input-error :messages="$errors->get('incoterms')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">C.I Value</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="ci_value" value="{{ old('ci_value') }}">
                                        <x-input-error :messages="$errors->get('ci_value')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Delivery Instructions mode of transport</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="mode_of_transport" value="{{ old('mode_of_transport') }}">
                                        <x-input-error :messages="$errors->get('mode_of_transport')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Delivery Address</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="delivery_address" value="{{ old('delivery_address') }}">
                                        <x-input-error :messages="$errors->get('delivery_address')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Split Delivery Address</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="split_delivery_address" value="{{ old('split_delivery_address') }}">
                                        <x-input-error :messages="$errors->get('split_delivery_address')" class="mt-2 list-unstyled"></x-input-error>
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
