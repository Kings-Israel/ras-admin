<div>
    <div class="body table-responsive">
        <div class="row">
            <div class="col-3">
                <input type="text" class="form-control" wire:model.live="search" placeholder="Search Document">
            </div>
        </div>
        <table class="table m-b-0">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>NO. OF COUNTRIES</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documents as $document)
                    <tr>
                        <td>{{ Str::title($document->name) }}</td>
                        <td>{{ $document->countries_count > 0 ? $document->countries_count : $countries->count().' - (ALL)' }}</td>
                        <td>
                            <div class="flex mx-2">
                                {{-- <a href="#editDocument_{{ $document->id }}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editDocument_{{ $document->id }}">Edit</a> --}}
                                <a href="{{ route('settings.document.edit', ['document' => $document]) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ route('settings.document.delete', ['document' => $document]) }}">
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @include('partials.admin.settings.edit-document')
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $documents->links() }}
        </div>
    </div>
</div>
