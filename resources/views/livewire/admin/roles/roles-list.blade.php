<div>
    <div class="body table-responsive">
        <div class="row">
            <div class="col-3">
                <input type="text" class="form-control" wire:model.live="search" placeholder="Search Role">
            </div>
        </div>
        <table class="table m-b-0">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>NO. OF PERMISSIONS</th>
                    <th>NO. OF USERS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ Str::title($role->name) }}</td>
                        <td>{{ $role->permissions_count }}</td>
                        <td>{{ $role->users_count }}</td>
                        <td>
                            <div class="flex mx-2">
                                <a href="{{ route('permissions.edit', ['role' => $role]) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ route('permissions.delete', ['role' => $role]) }}" class="btn btn-danger btn-sm">Delete</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $roles->links() }}
        </div>
    </div>
</div>
