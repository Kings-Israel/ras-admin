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
                        <div class="row">
                            <div class="col-7">
                         <table class="table table-striped table-hover dataTable js-exportable">
                         <thead>
                                    <tr>
                                     <th>#</th>
                                    <th>Wing</th>
                                    <th>Description</th>
                                    <th>Total Capacity</th>
                                    <th>Occupied Capacity</th>
                                     </tr>
                         </thead>
                             <tbody>
                             @forelse($wings as $key=>$wing)
                                 <tr>
                                     <td>{{$key}}</td>
                                     <td>{{$wing->wingname}}</td>
                                     <td>{{$wing->description}}</td>
                                     <td>{{$wing->capacity}}</td>
                                     <td>{{$wing->capacity}}</td>
                                     <td></td>
                                 </tr>
                             @empty
                                 <tr>
                                     <td colspan="5" class="text-center"> No Wing(s) and Location(s) Added Yet ...! </td>
                                 </tr>
                             @endforelse
                             </tbody>
                         </table>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-4 ">
                                <div class="container">
                                    <h5>Create Wing</h5>
                                    <form method="post" action="{{ route('wings.store') }}">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group  row">
                                        <div class="col-12 mb-2">
                                            @if ($errors->has('wingname'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('wingname') }}
                                                </div>
                                            @endif
                                            <label for="name">Wing Name</label>
                                            <input type="text" class="form-control" id="wingname" name="wingname" placeholder="Wing name label" value="{{ old('wingname') }}" required>
                                        </div>
                                        <div class="col-12 mb-2">
                                            @if ($errors->has('description'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('description') }}
                                                </div>
                                            @endif
                                            <label for="name">Wing Description</label>
                                            <input type="text" class="form-control" id="description" name="description" placeholder=" About wing" value="{{ old('description') }}" required>
                                        </div>
                                        <div class="col-6 mb-2">
                                            @if ($errors->has('capacity'))
                                                <div class="alert alert-danger">
                                                    {{ $errors->first('capacity') }}
                                                </div>
                                            @endif
                                            <label for="name">Wing Total Capacity</label>
                                            <input type="number" class="form-control" id="wcapacity" placeholder="Capacity " name="wcapacity" value="{{ old('wcapacity') }}" required>
                                        </div>
                                        <div class="col-6 mb2">
                                            <label for="name">Capacity Unit Of Measurement</label>
                                            <input type="text" class="form-control" id="wunit" placeholder="(Meter Cube)" name="wunit"  value="{{ old('wunit') }}" required>
                                        </div>
                                    </div>
                                        <div class="form-group" id="locations-container">
                                            <label>Locations</label>
                                            <div class="location-input-group row">
                                                <div class="col-12 mb-2">
                                                    <input type="text" class="form-control" name="locations[0][name]" placeholder="Location Name" required>
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <input type="number" class="form-control" name="locations[0][capacity]" placeholder="Capacity " required>
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <input type="text" class="form-control" name="locations[0][unit]" placeholder="Unit Of Measurement (Meter Cube)" required>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <button type="button" class="btn btn-sm btn-danger remove-location"><i class="fa fa-minus"></i>Remove</button>
                                                </div>
                                            </div>

                                        </div>
                                        <button type="button" class="btn btn-success float-left" id="add-location"><i class="fa fa-plus"></i> Add Location</button>

                                        <input type="hidden" name="warehouse_id" value="{{ $warehouse->id }}">

                                        <button type="submit" class="btn btn-primary float-right">Create Wing</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                // Function to update button visibility
                                function updateButtonVisibility() {
                                    var locationGroups = $(".location-input-group");
                                    if (locationGroups.length > 1) {
                                        $(".remove-location").show();
                                    } else {
                                        $(".remove-location").hide();
                                    }
                                }

                                // Initial visibility check
                                updateButtonVisibility();

                                // Add location
                                $("#add-location").click(function() {
                                    var newIndex = $(".location-input-group").length;

                                    var newLocationGroup = $("<div class='location-input-group row'>" +
                                        "<div class='col-12 mb-2'><input type='text' class='form-control' name='locations[" + newIndex + "][name]' placeholder='Location Name' required></div>" +
                                        "<div class='col-6 mb-2'><input type='number' class='form-control' name='locations[" + newIndex + "][capacity]' placeholder='Capacity' required></div>" +
                                        "<div class='col-6 mb-2'><input type='text' class='form-control' name='locations[" + newIndex + "][unit]' placeholder='Unit Of Measurement' required></div>" +
                                        "<div class='col-12 mb-2'><button type='button' class='btn btn-sm btn-danger remove-location'><i class='fa fa-minus'></i> Remove</button></div>" +
                                        "</div>");

                                    $("#locations-container").append(newLocationGroup);
                                    updateButtonVisibility();
                                });

                                // Remove location
                                $("#locations-container").on("click", ".remove-location", function() {
                                    $(this).closest(".location-input-group").remove();
                                    updateButtonVisibility();
                                });
                            });

                        </script>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
