@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
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
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr><th>Image</th>
                                    <th>Name</th>
                                    <th>Product Owner</th>
                                    <th>Category</th>
{{--                                    <th>Price</th>--}}
{{--                                    <th>Unit(UOM)</th>--}}
{{--                                    <th>Packaging</th>--}}
{{--                                    <th>Location</th>--}}
                                    <th>Warehouse</th>
{{--                                    <th>Added On</th>--}}
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
<<<<<<< HEAD
                                    <tr>
                                        <td>
                                            @if($product->image)
                                                <img src="{{ asset($product->image->path) }}" alt="{{ $product->name }}" style="max-width: 100px; max-height: 100px; border-radius: 50%;">
                                            @else
                                                <img src="{{ asset('assets/images/product-placeholder.png') }}" alt="Placeholder" style="max-width: 100px; max-height: 100px; border-radius: 50%;">
                                            @endif
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->business->name ?? '' }}</td>
                                        <td>{{ $product->category->name ?? ''}}</td>
{{--                                        <td>{{ $product->price ? $product->price : $product->min_price.' - '.$product->max_price }}</td>--}}
                                        <td>{{ $product->warehouse ?? '' }}</td>
{{--                                        <td>{{ $product->created_at->format('d M Y') }}</td>--}}
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary btn-round waves-effect"  data-bs-toggle="modal" data-bs-target="#productModal" onclick="showProductDetails({{$product->id}})">DETAILS</a>
                                        </td>
                                    </tr>
=======
                                    @can('view', $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->business->name }}</td>
                                            <td>{{ $product->price ? $product->price : $product->min_price.' - '.$product->max_price }}</td>
                                            <td>{{ $product->warehouse }}</td>
                                            <td>{{ $product->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-primary btn-round waves-effect">DETAILS</a>
                                            </td>
                                        </tr>
                                    @endcan
>>>>>>> add7acdb7e3ccb81542ac8ed7fcbfe2eba3b85dd
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
@endpush
