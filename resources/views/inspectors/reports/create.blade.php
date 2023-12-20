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
                        <form action="{{ route('inspection.requests.reports.store', ['order_request' => $order_request]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row clearfix">
                                <div class="col-12">
                                    <h5>Applicant</h5>
                                </div>
                                {{-- Applicant --}}
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Applicant Company Name</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Applicant Company Name" name="applicant_company_name" value="{{ old('applicant_company_name', $order_request->requesteable->name) }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('applicant_company_name')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Applicant Company Address</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Applicant Company Address" name="applicant_company_address" value="{{ old('applicant_company_address') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('applicant_company_address')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Applicant Company Email</label>
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="applicant_company_email" value="{{ old('applicant_company_email', $order_request->requesteable->email) }}">
                                        <x-input-error :messages="$errors->get('applicant_company_email')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Applicant Company Phone Number</label>
                                    <div class="form-group">
                                        <input type="tel" class="form-control" name="applicant_company_phone_number" value="{{ old('applicant_company_phone_number', $order_request->requesteable->phone_number) }}">
                                        <x-input-error :messages="$errors->get('applicant_company_phone_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Applicant Company Contact Person</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Applicant Company Contact Person" name="applicant_company_contact_person" value="{{ old('applicant_company_contact_person', auth()->user()->first_name.' '.auth()->user()->last_name) }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('applicant_company_contact_person')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Applicant Company Contact Person Email</label>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Enter Applicant Company Contact Person" name="applicant_company_contact_person_email" value="{{ old('applicant_company_contact_person_email', auth()->user()->email) }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('applicant_company_contact_person_email')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Applicant Company Contact Person Phone Number</label>
                                    <div class="form-group">
                                        <input type="tel" class="form-control" name="applicant_company_contact_person_phone_number" value="{{ old('applicant_company_contact_person_phone_number', auth()->user()->phone_number) }}">
                                        <x-input-error :messages="$errors->get('applicant_company_contact_person_phone_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                {{-- End Applicant --}}
                                {{-- License Holder --}}
                                <div class="col-12">
                                    <h5>License Holder</h5>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">License Company Name</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter License Company Name" name="license_holder_company_name" value="{{ old('license_holder_company_name') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('license_holder_company_name')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">License Company Address</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter License Company Address" name="license_holder_company_address" value="{{ old('license_holder_company_address') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('license_holder_company_address')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">License Company Email</label>
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="license_holder_company_email" :value="old('license_holder_company_email')">
                                        <x-input-error :messages="$errors->get('license_holder_company_email')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">License Company Phone Number</label>
                                    <div class="form-group">
                                        <input type="tel" class="form-control" name="license_holder_company_phone_number" :value="old('license_holder_company_phone_number')">
                                        <x-input-error :messages="$errors->get('license_holder_company_phone_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Licenst Company Contact Person</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter License Holder Company Contact Person" name="license_holder_company_contact_person" value="{{ old('license_holder_company_contact_person') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('license_holder_company_contact_person')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">License Company Contact Person Email</label>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Enter License Company Contact Person Email" name="license_holder_company_contact_person_email" value="{{ old('license_holder_company_contact_person_email') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('license_holder_company_contact_person_email')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">License Company Contact Person Phone Number</label>
                                    <div class="form-group">
                                        <input type="tel" class="form-control" name="license_holder_company_contact_person_phone_number" :value="old('license_holder_company_contact_person_phone_number')">
                                        <x-input-error :messages="$errors->get('license_holder_company_contact_person_phone_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                {{-- End License Holder --}}
                                {{-- Place of Manufacture --}}
                                <div class="col-12">
                                    <h5>Place of Manufacture</h5>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Place of Manufacture Company Name</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Manufacture Place Company Name" name="place_of_manufacture_company_name" value="{{ old('place_of_manufacture_company_name') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('place_of_manufacture_company_name')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Place of Manufacture Company Address</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Manufacture Place Company Address" name="place_of_manufacture_company_address" value="{{ old('place_of_manufacture_company_address') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('place_of_manufacture_company_address')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Place of Manufacture Company Email</label>
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="place_of_manufacture_company_email" :value="old('place_of_manufacture_company_email')">
                                        <x-input-error :messages="$errors->get('place_of_manufacture_company_email')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Place of Manufacture Company Phone Number</label>
                                    <div class="form-group">
                                        <input type="tel" class="form-control" name="place_of_manufacture_company_phone_number" :value="old('place_of_manufacture_company_phone_number')">
                                        <x-input-error :messages="$errors->get('place_of_manufacture_company_phone_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Place of Manufacture Company Contact Person</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Manufacture Place Holder Company Contact Person" name="place_of_manufacture_company_contact_person" value="{{ old('place_of_manufacture_company_contact_person') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('place_of_manufacture_company_contact_person')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Place of Manufacture Company Contact Person Email</label>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Enter Manufacture Place Company Contact Person Email" name="place_of_manufacture_company_contact_person_email" value="{{ old('place_of_manufacture_company_contact_person_email') }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('place_of_manufacture_company_contact_person_email')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Place of Manufacture Company Contact Person Phone Number</label>
                                    <div class="form-group">
                                        <input type="tel" class="form-control" name="place_of_manufacture_company_contact_person_phone_number" :value="old('place_of_manufacture_company_contact_person_phone_number')">
                                        <x-input-error :messages="$errors->get('place_of_manufacture_company_contact_person_phone_number')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                {{-- End place of Manufacture --}}

                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Place of Manufacture Inspection Done By</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="place_of_manufacture_factory_inspection_done_by" :value="old('place_of_manufacture_factory_inspection_done_by')">
                                        <x-input-error :messages="$errors->get('place_of_manufacture_factory_inspection_done_by')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                {{-- Product --}}
                                <div class="col-12">
                                    <h5>Product</h5>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Product</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Product" name="product" value="{{ old('product', $order_request->orderItem->product->name) }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('product')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="name">Product Type Ref</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="" name="product_type_ref" value="{{ old('product_type_ref', $order_request->orderitem->product->model_number) }}" autocomplete="off" />
                                        <x-input-error :messages="$errors->get('product_type_ref')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <label for="Max Capacity">Product Trademark</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="product_trade_mark" :value="old('product_trade_mark')">
                                        <x-input-error :messages="$errors->get('product_trade_mark')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="Max Capacity">Product Ratings and Principle Characteristics</label>
                                    <div class="form-group">
                                        <textarea type="text" class="form-control" name="product_ratings_and_principle_characteristics" rows="3"></textarea>
                                        <x-input-error :messages="$errors->get('product_ratings_and_principle_characteristics')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="Max Capacity">Differences From Previously Certifed Product</label>
                                    <div class="form-group">
                                        <textarea type="text" class="form-control" name="differences_from_previously_certified_product" rows="3"></textarea>
                                        <x-input-error :messages="$errors->get('differences_from_previously_certified_product')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="">General Product Validity Status</label>
                                            <select name="product_validity" id="" class="form-control">
                                                <option value="valid">Valid</option>
                                                <option value="invalid">Invalid</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="Max Capacity">Applicant Signature</label>
                                    <div class="form-group">
                                        <input type="file" accept=".pdf" name="applicant_sign" class="form-control" id="" />
                                        <x-input-error :messages="$errors->get('applicant_sign')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="Max Capacity">Certificate</label>
                                    <div class="form-group">
                                        <input type="file" accept=".pdf" name="report" class="form-control" id="" required />
                                        <x-input-error :messages="$errors->get('report')" class="mt-2 list-unstyled"></x-input-error>
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
