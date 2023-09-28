<div class="card">
    <div class="header">
        <div class="d-flex justify-content-between">
            <h2 class="my-auto"><strong>Cities/Towns</strong></h2>
        </div>
    </div>
    <div class="body table-responsive">
        <div class="row">
            <div class="col-3">
                <input type="text" class="form-control" wire:model.live="search" placeholder="Search City">
            </div>
        </div>
        <table class="table m-b-0">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>NO. OF BUSINESSES</th>
                    <th>NO. OF WAREHOUSES</th>
                    <th>COORDIINATES</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cities as $city)
                    <tr>
                        <td>{{ Str::title($city->name) }}</td>
                        <td>{{ $city->businesses_count }}</td>
                        <td>{{ $city->warehouses_count }}</td>
                        <td>{{ $city->latitude }}, {{ $city->longitude }}</td>
                        <td>
                            <div class="flex mx-2">
                                <a href="#editCity_{{ $city->id }}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editCity_{{ $city->id }}">Edit</a>
                                <a href="{{ route('settings.city.delete', ['city' => $city]) }}">
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @include('partials.admin.settings.edit-city')
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $cities->links() }}
        </div>
    </div>
</div>
