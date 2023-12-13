<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        return view('permissions.index', [
            'page' => 'Roles and Permissions',
            'breadcrumbs' => [
                'Roles and Permissions' => route('permissions.index'),
            ],
        ]);
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode(' ', $permission->name, 2)[1];
        });

        return view('permissions.create', [
            'page' => 'Add Role',
            'breadcrumbs' => [
                'Roles and Permissions' => route('permissions.index'),
                'Add' => route('permissions.create'),
            ],
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_name' => ['required', 'string', 'unique:roles,name']
        ], [
            'role_name.unique' => 'The Role Name already exists'
        ]);

        $role = Role::create([
            'name' => $request->role_name
        ]);

        if($request->has('permissions') && count($request->permissions) > 0) {
            foreach($request->permissions as $permission) {
                $permission = Permission::find($permission);

                $role->givePermissionTo($permission);
            }
        }

        toastr()->success('', 'Role created successfully');

        return redirect()->route('permissions.index');
    }

    public function edit(Role $role)
    {
        $role = Role::with(['permissions' => function($query) {
                        $query->select('id');
                    }])
                    ->find($role->id);

        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode(' ', $permission->name, 2)[1];
        });

        return view('permissions.edit', [
            'page' => 'Edit Roles and Permissions',
            'breadcrumbs' => [
                'Roles and Permissions' => route('permissions.index'),
                'Edit' => route('permissions.edit', ['role' => $role]),
            ],
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => ['required', 'array']
        ]);

        $role->update([
            'name' => $request->get('name'),
        ]);

        $role->permissions->each(function ($permission) use ($role) {
            $role->revokePermissionTo($permission);
        });

        collect($request->permissions)->each(function ($permission) use ($role) {
            $role->givePermissionTo($permission);
        });

        toastr()->success('', 'Role updated successfully');

        return redirect()->route('permissions.index');
    }

    public function delete($id)
    {
        Role::destroy($id);

        toastr()->success('', 'Role deleted successfully');

        return redirect()->route('permissions.index');
    }
}
