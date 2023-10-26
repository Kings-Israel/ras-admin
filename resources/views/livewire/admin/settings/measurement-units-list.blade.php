<div class="card">
    <div class="header">
        <div class="d-flex justify-content-between">
            <h2 class="my-auto"><strong>Product Measurement Units</strong></h2>
            @can('update settings')
                <a class="btn btn-secondary btn-sm" href="#" data-toggle="modal" data-target="#addUnit">Add Unit</a>
            @endcan
        </div>
        @can('update settings')
            <div class="modal fade" id="addUnit" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title" id="addUnitLabel">Add Unit</h4>
                        </div>
                        <form action="#" method="POST" wire:submit="createUnit">
                            @csrf
                            <div class="modal-body">
                                <div class="row clearfix">
                                    <div class="col-12">
                                        <label for="role_name">Name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Name" name="name" wire:model="name" required autocomplete="off" />
                                            <x-input-error :messages="$errors->get('name')" class="mt-2 list-unstyled"></x-input-error>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="role_name">Abbreviation</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Abbrev." name="abbrev" wire:model="abbrev" autocomplete="off" />
                                            <x-input-error :messages="$errors->get('abbrev')" class="mt-2 list-unstyled"></x-input-error>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-round waves-effect">SAVE</button>
                                <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <div class="body table-responsive">
        <div class="row">
            <div class="col-7">
                <input type="text" class="form-control" wire:model.live="search" placeholder="Search Unit">
            </div>
        </div>
        <table class="table m-b-0">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>ABBREV.</th>
                    @can('update settings')
                        <th>ACTIONS</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($units as $unit)
                    <tr>
                        <td>{{ Str::title($unit->name) }}</td>
                        <td>{{ $unit->abbrev }}</td>
                        @can('update settings')
                            <td>
                                <div class="flex mx-2">
                                    <a href="#editUnits_{{ $unit->id }}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUnits_{{ $unit->id }}">Edit</a>
                                    <a href="{{ route('settings.unit.delete', ['unit' => $unit]) }}">
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </a>
                                </div>
                            </td>
                        @endcan
                    </tr>
                    @can('update settings')
                        @include('partials.admin.settings.edit-unit')
                    @endcan
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $units->links() }}
        </div>
    </div>
</div>
