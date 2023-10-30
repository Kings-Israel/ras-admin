<div>
    <div class="body table-responsive">
        <div class="row">
            <div class="col-3">
                <input type="text" class="form-control" wire:model.live="search" placeholder="Search Logs">
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Log</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        @if ($log->subject && $log->subject_type == App\Models\Product::class)
                            <td>{{ $log->causer->first_name }} {{ $log->causer->last_name }} {{ $log->description }} {{ $log->subject->name }}</td>
                        @else
                            <td>{{ $log->causer->first_name }} {{ $log->causer->last_name }} {{ $log->description }}</td>
                        @endif
                        <td>{{ $log->created_at->format('d M Y H:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $logs->links() }}
        </div>
    </div>
</div>
