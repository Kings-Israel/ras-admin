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
                        <a class="btn btn-secondary btn-sm btn-round" href="#defaultModal" data-toggle="modal" data-target="#defaultModal">Create Campaign</a>
                        <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="title" id="defaultModalLabel">Add Marketing Poster</h4>
                                    </div>
                                    <form action="{{ route('marketing.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row clearfix">
                                                <div class="col-12">
                                                    <label for="role_name">Poster</label>
                                                    <div class="form-group">
                                                        <input type="file" class="form-control" name="poster" required accept=".jpg,.png" />
                                                        <x-input-error :messages="$errors->get('poster')" class="mt-2 list-unstyled"></x-input-error>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label for="description">Description</label>
                                                    <div class="form-group">
                                                        <textarea name="description" class="form-control" rows="4"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <label for="description">Description Text Color</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="description_text_color" />
                                                        <x-input-error :messages="$errors->get('description_text_color')" class="mt-2 list-unstyled"></x-input-error>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <label for="description">Description Text Align</label>
                                                    <div class="form-group">
                                                        <select name="description_text_align" class="form-select">
                                                            <option value="center">Center</option>
                                                            <option value="right">Right</option>
                                                            <option value="left">Left</option>
                                                        </select>
                                                        <x-input-error :messages="$errors->get('description_text_align')" class="mt-2 list-unstyled"></x-input-error>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <label for="description">Description Text Font Size in pixels</label>
                                                    <div class="form-group">
                                                        <input type="number" min="1" class="form-control" name="description_font_size" />
                                                        <x-input-error :messages="$errors->get('description_font_size')" class="mt-2 list-unstyled"></x-input-error>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary btn-round waves-effect">Submit</button>
                                            <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <table class="table table-bordered table-striped table-hover dataTable" id="marketing">
                            <thead>
                                <tr>
                                    <th>Poster</th>
                                    <th>Description</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($marketing_posters as $poster)
                                    <tr>
                                        <td>
                                            <img src="{{ $poster->image }}" alt="Poster" width="120px">
                                        </td>
                                        <td>{{ $poster->description }}</td>
                                        <td>{{ $poster->created_at->format('d M Y H:i A') }}</td>
                                        <td>
                                            <button class="btn btn-round btn-primary btn-sm" data-toggle="modal" data-target="#defaultModal_{{ $poster->id }}">Edit</button>
                                            <div class="modal fade" id="defaultModal_{{ $poster->id }}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="title" id="defaultModalLabel">Update Marketing Poster</h4>
                                                        </div>
                                                        <form action="{{ route('marketing.update', ['marketing_poster' => $poster]) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="row clearfix">
                                                                    <div class="col-12">
                                                                        <label for="role_name">Poster</label>
                                                                        <div class="form-group">
                                                                            <input type="file" class="form-control" name="poster" accept=".jpg,.png" />
                                                                            <x-input-error :messages="$errors->get('poster')" class="mt-2 list-unstyled"></x-input-error>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="description">Description</label>
                                                                        <div class="form-group">
                                                                            <textarea name="description" class="form-control" rows="4">{{ $poster->description }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <label for="description">Description Text Color</label>
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control" name="description_text_color" value="{{ $poster->description_text_color }}" />
                                                                            <x-input-error :messages="$errors->get('description_text_color')" class="mt-2 list-unstyled"></x-input-error>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <label for="description">Description Text Align</label>
                                                                        <div class="form-group">
                                                                            <select name="description_text_align" class="form-select">
                                                                                <option value="center" @if($poster->description_text_align == 'center') selected @endif>Center</option>
                                                                                <option value="right" @if($poster->description_text_align == 'right') selected @endif>Right</option>
                                                                                <option value="left" @if($poster->description_text_align == 'left') selected @endif>Left</option>
                                                                            </select>
                                                                            <x-input-error :messages="$errors->get('description_text_align')" class="mt-2 list-unstyled"></x-input-error>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <label for="description">Description Text Font Size in pixels</label>
                                                                        <div class="form-group">
                                                                            <input type="number" min="1" class="form-control" name="description_font_size" value="{{ $poster->font_size }}" />
                                                                            <x-input-error :messages="$errors->get('description_font_size')" class="mt-2 list-unstyled"></x-input-error>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary btn-round waves-effect">Submit</button>
                                                                <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
        $('#marketing').DataTable( {
            ordering: true
        } );
    </script>
@endpush
