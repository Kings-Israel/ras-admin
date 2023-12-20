@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
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
                    <div>
                        @role('warehouse manager')
                                                <a href="{{route('product.create')}}" class="btn btn-sm btn-primary btn-round waves-effect" >Add Product</a>

{{--                        <x-primary-button class="btn btn-sm btn-primary btn-round waves-effect" data-modal-target="add-product-modal" data-modal-toggle="add-product-modal">Add Product</x-primary-button>--}}
{{--                <x-product-modal modal_id="add-product-modal" name="Create Product">--}}

{{--                    <div class="relative w-full max-w-4xl max-h-full">--}}
{{--                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">--}}
{{--                            <button type="button" data-modal-hide="add-product-modal" class="absolute top-1 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">--}}
{{--                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">--}}
{{--                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>--}}
{{--                                </svg>--}}
{{--                                <span class="sr-only">Close modal</span>--}}
{{--                            </button>--}}
{{--                            <div class="px-2 py-2 lg:px-4">--}}
{{--                                <h3 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white space-y-4">New Product</h3>--}}
{{--                                @include('products.create')--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </x-product-modal>--}}
        @endrole
            </div>
                    <br/>
                    <br/>
                    <div class="body">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr><th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>SKU Code/Model</th>
{{--                                    <th>Unit(UOM)</th>--}}
{{--                                    <th>Packaging</th>--}}
{{--                                    <th>Location</th>--}}
                                    @role('warehouse manager')
                                         <td>Wing/Location</td>
{{--                                        <th>Last Restocked On</th>--}}
                                        <th>Quantity</th>
                                    @else
                                        <th>Product Owner</th>
                                        <th>Warehouse</th>
                                    @endrole
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            @if($product && $product->product && ($product->media || $product->product->media))
                                                @foreach($product->media ?? $product->product->media as $media)
                                                    @if($media->type =='image')
                                                        <img src="{{ asset($media->file) }}" alt="{{ $product->product->name ?? $product->name}}" style="max-width: 80px; max-height: 80px; border-radius: 50%;">
                                                    @endif
                                                @endforeach
                                            @else
                                                <img src="{{ asset('assets/images/product-placeholder.png') }}" alt="Placeholder" style="max-width: 100px; max-height: 100px; border-radius: 50%;">
                                            @endif
                                        </td>
                                        <td>{{ $product->name ?? $product->product->name ?? '' }}</td>
                                        <td>{{ $product->category->name ?? $product->product->category->name ?? ''}}</td>
                                        <td>{{ $product->model_number ?? $product->product->model_number ?? ''}}</td>
{{--                                        <td>{{ $product->price ? $product->price : $product->min_price.' - '.$product->max_price }}</td>--}}
                                        @role('warehouse manager')
                                            <td>
                                                @if (!empty($product->winglocation))
                                                    {{ optional($product->winglocation->wing)->wingname ?? '' }}
                                                    , {{ optional($product->winglocation)->location_name ?? '' }}
                                                @endif
                                            </td>
{{--                                            <td>{{$product->updated_at ?? ''}}</td>--}}
                                            <td>{{$product->quantity ?? ''}}</td>
                                        @else
                                            <td>{{ $product->business->name ?? $product->product->business->name ?? '' }}</td>
                                        <td>{{ $product->warehouse->name ?? $product->product->warehouse->name ??  '' }}</td>
                                        @endrole

                                           <td>
                                               <a class="btn btn-sm btn-secondary" href="{{route('product.details', $product->product->id ?? $product->id)}}"><span>Details</span></a>
                                           </td>
                                            <td>
                                                <a class="btn btn-sm btn-primary" href="{{route('product.restock', $product->product->id ?? $product->id)}}" class="btn btn-sm btn-secondary btn-round waves-effect" ><span>Restock</span></a>
                                            </td>

                                    </tr>
{{--                                    @can('view', $product)--}}
{{--                                        <tr>--}}
{{--                                            <td>{{ $product->name }}</td>--}}
{{--                                            <td>{{ $product->business->name }}</td>--}}
{{--                                            <td>{{ $product->price ? $product->price : $product->min_price.' - '.$product->max_price }}</td>--}}
{{--                                            <td>{{ $product->warehouse }}</td>--}}
{{--                                            <td>{{ $product->created_at->format('d M Y') }}</td>--}}
{{--                                            <td>--}}
{{--                                                <a href="#" class="btn btn-sm btn-primary btn-round waves-effect">DETAILS</a>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endcan--}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Inside the modal body -->
                <div class="modal-body">
                    <h5>Product Details</h5>
                    <table class="table">
                        <tr>
                            <th>Name:</th>
                            <td id="productName"></td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td id="productDescription"></td>
                        </tr>
                        <tr>
                            <th>Material:</th>
                            <td id="productMaterial"></td>
                        </tr>
                        <tr>
                            <th>Price:</th>
                            <td id="productPrice"></td>
                        </tr>
                        <!-- Add more rows for other details as needed -->
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</section>
<script>
    function showProductDetails(productId) {
        const apiUrl = `/api/products/${productId}`;
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                const product = data[0];
                document.getElementById('productName').textContent = product.name;
                document.getElementById('productDescription').textContent = product.description;
                document.getElementById('productMaterial').textContent = product.material;
                document.getElementById('productPrice').textContent = product.price;
            })
            .catch(error => console.error('Error fetching product details', error));
    }
</script>

@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>


    <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
        <script src="{{ asset('assets/js/product-wizard.js') }}"></script>
        <script>
            // function showCapacityInput() {
            //     let selected_warehouse = $('#link_to_warehouse').find(':selected').val()
            //     if (selected_warehouse === '') {
            //         $('#product_capacity').addClass('hidden')
            //     } else {
            //         $('#product_capacity').removeClass('hidden')
            //     }
            // }
            function enterCustom(value, element_id) {
                if (value.checked) {
                    $('#'+element_id).addClass('hidden')
                    $('#'+element_id).removeClass('block')
                    $('#custom_'+element_id).addClass('block')
                    $('#custom_'+element_id).removeClass('hidden')
                    $('#custom_'+element_id).focus()
                } else {
                    $('#'+element_id).addClass('block')
                    $('#'+element_id).removeClass('hidden')
                    $('#'+element_id).focus()
                    $('#custom_'+element_id).addClass('hidden')
                    $('#custom_'+element_id).removeClass('block')
                }
            }

            function setInput(input) {
                $('#'+input).val($('#custom_'+input).val())
            }

            function dropdown() {
                return {
                    options: [],
                    selected: [],
                    show: false,
                    open() { this.show = true },
                    close() { this.show = false },
                    isOpen() { return this.show === true },
                    select(index, event) {
                        if (!this.options[index].selected) {

                            this.options[index].selected = true;
                            this.options[index].element = event.target;
                            this.selected.push(index);

                        } else {
                            this.selected.splice(this.selected.lastIndexOf(index), 1);
                            this.options[index].selected = false
                        }
                    },
                    remove(index, option) {
                        this.options[option].selected = false;
                        this.selected.splice(index, 1);
                    },
                    loadOptions() {
                        const options = document.getElementById('select').options;
                        for (let i = 0; i < options.length; i++) {
                            this.options.push({
                                value: options[i].value,
                                text: options[i].innerText,
                                selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                            });
                        }
                    },
                    selectedValues(){
                        return this.selected.map((option)=>{
                            return this.options[option].value;
                        })
                    }
                }
            }

            let selected_warehouses = []
            function getSelectedWarehouses(product) {
                let warehouses = product.warehouses

                warehouses.forEach(warehouse => {
                    selected_warehouses.push(warehouse.id)
                });
            }

            function updateWarehouses(product) {
                let warehouses = product.warehouses

                warehouses.forEach(warehouse => {
                    selected_warehouses.push(warehouse.id)
                });

                return {
                    options: [],
                    selected: [...selected_warehouses],
                    show: false,
                    open() { this.show = true },
                    close() { this.show = false },
                    isOpen() { return this.show === true },
                    select(index, event) {
                        if (!this.options[index].selected) {
                            this.options[index].selected = true;
                            this.options[index].element = event.target;
                            this.selected.push(index);

                        } else {
                            this.selected.splice(this.selected.lastIndexOf(index), 1);
                            this.options[index].selected = false
                        }
                    },
                    remove(index, option) {
                        this.options[option].selected = false;
                        this.selected.splice(index, 1);
                    },
                    loadOptions() {
                        const options = document.getElementById('select').options;
                        for (let i = 0; i < options.length; i++) {
                            this.options.push({
                                value: options[i].value,
                                text: options[i].innerText,
                                selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                            });
                        }
                    },
                    selectedValues(){
                        return this.selected.map((option)=>{
                            return this.options[option].value;
                        })
                    }
                }
            }
        </script>

{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>--}}
    @endpush
