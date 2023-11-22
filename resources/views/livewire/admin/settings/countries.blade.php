<div>
    <div class="body table-responsive">
        <div class="row">
            <div class="col-3">
                <input type="text" class="form-control" wire:model.live="search" placeholder="Search Country">
            </div>
        </div>
        <table class="table m-b-0">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>NO. OF CITIES/TOWNS</th>
                    <th>NO. OF BUSINESSES</th>
                    <th>NO. OF WAREHOUSES</th>
                    @can('update settings')
                        <th>ACTIONS</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($countries as $country)
                    <tr>
                        <td>{{ Str::title($country->name) }}</td>
                        <td>{{ $country->cities_count }}</td>
                        <td>{{ $country->businesses_count }}</td>
                        <td>{{ $country->warehouses_count }}</td>
                        @can('update settings')
                            <td>
                                <div class="flex mx-2">
                                    {{-- <a href="#defaultModal_{{ $document->id }}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#defaultModal_{{ $document->id }}">Edit</a> --}}
                                    <a href="{{ route('settings.country.edit', ['country' => $country]) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="#deleteCountry_{{ $country->id }}" data-toggle="modal" data-target="#deleteCountry_{{ $country->id }}">
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </a>
                                </div>
                            </td>
                        @endcan
                    </tr>
                    @can('update settings')
                        @include('partials.admin.settings.delete-country')
                    @endcan
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $countries->links() }}
        </div>
    </div>
</div>
