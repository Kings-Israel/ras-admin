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
                    <div class="header d-flex justify-content-between">
                        <h2><strong>{{ Str::title($page) }}</strong></h2>
                        @if ($business->approval_status == 'approved')
                            @if (!$business->verified())
                                <a href="{{ route('vendors.verify', ['business' => $business]) }}" class="btn btn-primary btn-sm btn-round">Verify</a>
                            @else
                                <span class="btn btn-success btn-sm btn-round">Verified</span>
                            @endif
                        @elseif ($business->approval_status == 'rejected')
                            <form method="POST" action="{{ route('vendors.update', ['business' => $business]) }}">
                                @csrf
                                <input type="hidden" name="approval_status" value="approved">
                                <a href="{{ route('vendors.update', ['business' => $business]) }}"
                                    onclick="event.preventDefault();
                                    this.closest('form').submit();"
                                    class="btn btn-primary btn-sm btn-round">Approve
                                </a>
                            </form>
                        @else
                            <div class="row">
                                <div class="col-6">
                                    {{-- <a href="" class="btn btn-primary btn-sm btn-round">Approve</a> --}}
                                    <form method="POST" action="{{ route('vendors.update', ['business' => $business]) }}">
                                        @csrf
                                        <input type="hidden" name="approval_status" value="approved">
                                        <a href="{{ route('vendors.update', ['business' => $business]) }}"
                                            onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                            class="btn btn-primary btn-sm btn-round">Approve
                                        </a>
                                    </form>
                                </div>
                                <div class="col-6">
                                    {{-- <a href="" class="btn btn-danger btn-sm btn-round">Reject</a> --}}
                                    <form method="POST" action="{{ route('vendors.update', ['business' => $business]) }}">
                                        @csrf
                                        <input type="hidden" name="approval_status" value="rejected">
                                        <a href="{{ route('vendors.update', ['business' => $business]) }}"
                                            onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                            class="btn btn-danger btn-sm btn-round">Reject
                                        </a>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <h6 class="card-title">Business Details</h6>
                            <div class="body">
                                <h5><span class="mr-2">Name:</span><strong>{{ $business->name }}</strong></h5>
                                <h5><span class="mr-2">Country:</span><strong>{{ $business->country->name }}</strong></h5>
                                @if ($business->city)
                                    <h5><span class="mr-2">City:</span><strong>{{ $business->city->name }}</strong></h5>
                                @endif
                                <h5><span class="mr-2">Registered On:</span><strong>{{ $business->created_at->format('d M Y') }}</strong></h5>
                                @if ($business->contact_email)
                                    <h5><span class="mr-2">Business Email:</span><strong>{{ $business->contact_email }}</strong></h5>
                                @endif
                                @if ($business->contact_phone_number)
                                    <h5><span class="mr-2">Business Phone Number:</span><strong>{{ $business->contact_phone_number }}</strong></h5>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="d-flex justify-content-between">
                                <h6 class="card-title">User</h6>
                                <a href="{{ route('users.show', ['user' => $business->user]) }}" class="btn btn-primary btn-sm mb-2">View User</a>
                            </div>
                            <div class="body">
                                <h5><span class="mr-2">Name:</span><strong>{{ $business->user->first_name }} {{ $business->user->last_name }}</strong></h5>
                                <h5><span class="mr-2">Email:</span><strong>{{ $business->user->email }}</strong></h5>
                                <h5><span class="mr-2">Phone Number:</span><strong>{{ $business->user->phone_number }}</strong></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        @if ($business->documents)
                            <h6>Business Documents</h6>
                            <div class="card">
                                <div class="body">
                                    @foreach ($business->documents as $document)
                                        <a href="{{ $document->file }}" target="_blank" class="btn btn-sm btn-round btn-primary wave-effect">{{ $document->name }} @if($document->expires_on) ({{ Carbon\Carbon::parse($document->expires_on)->format('d M Y') }}) @endif</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    @if ($business->about || $business->mission || $business->vision || $business->tag_line)
                        <div class="col-12">
                            <div class="card">
                                <div class="body">
                                    @if ($business->about)
                                        <span><strong>About</strong></span>
                                        <br>
                                        <span>{{ $business->about }}</span>
                                        <br>
                                    @endif
                                    @if ($business->mission)
                                        <span><strong>Mission</strong></span>
                                        <br>
                                        <span>{{ $business->mission }}</span>
                                        <br>
                                    @endif
                                    @if ($business->vision)
                                        <span><strong>Vision</strong></span>
                                        <br>
                                        <span>{{ $business->vision }}</span>
                                        <br>
                                    @endif
                                    @if ($business->tag_line)
                                        <span><strong>Tag Line</strong></span>
                                        <br>
                                        <span>{{ $business->tag_line }}</span>
                                        <br>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-3 col-sm-12">
                        <div class="card text-center">
                            <div class="body">
                                <p class="m-b-20"><i class="zmdi zmdi-assignment zmdi-hc-3x col-blue"></i></p>
                                <span>Products</span>
                                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $business->products_count }}" data-speed="10" data-fresh-interval="5">{{ $business->products_count }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="card text-center">
                            <div class="body">
                                <p class="m-b-20"><i class="zmdi zmdi-shopping-basket zmdi-hc-3x"></i></p>
                                <span>Orders</span>
                                <h3 class="m-b-10 number count-to" data-from="0" data-to="{{ $business->orders_count }}" data-speed="10" data-fresh-interval="5">{{ $business->orders_count }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h6 class="card-title">Products</h6>
                    <div class="body">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="products">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Warehouse</th>
                                    <th>Added On</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($business->products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->price ? $product->price : $product->min_price.' - '.$product->max_price }}</td>
                                        <td>{{ $product->warehouse }}</td>
                                        <td>{{ $product->created_at->format('d M Y H:i A') }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary btn-round waves-effect">DETAILS</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <h6 class="card-title">Orders</h6>
                    <div class="body">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="orders">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>User Name</th>
                                    <th>Products</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($business->orders as $order)
                                    <tr>
                                        <td>{{ $order->order_id }}</td>
                                        <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                                        <td>{{ $order->orderItems->count() }}</td>
                                        <td><span class="badge {{ $order->resolveOrderBadgeStatus() }}">{{ Str::title($order->status) }}</span></td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary btn-round waves-effect">DETAILS</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script> --}}
    <script>
        $('#orders').DataTable().order([4, 'desc']).draw();
        $('#products').DataTable().order([3, 'desc']).draw();
    </script>
@endpush
