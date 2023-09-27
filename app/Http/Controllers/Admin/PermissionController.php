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
        $roles = Role::withCount('permissions', 'users')->where('name', '!=', 'admin')->get();

        return view('permissions.index', [
            'roles' => $roles,
            'breadcrumbs' => [
                'Roles and Permissions' => route('permissions.index'),
            ],
        ]);
    }

    public function create()
    {
        $permissions = Permission::all();

        return view('permissions.create', [
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
            'role_name' => 'required', 'string'
        ]);

        dd($request->all());
    }

    public function edit(Role $role)
    {
        $role = Role::with(['permissions' => function($query) {
                        $query->select('id');
                    }])->find($role->id);

        $permissions = Permission::all();

        return view('permissions.edit', [
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
            'name' => 'required'
        ]);

        $role->update([
            'name' => $request->get('name'),
        ]);

        session()->put('success', 'Role updated');

        return redirect()->route('permissions.index');
    }

    public function delete($id)
    {
        Role::destroy($id);

        return;
    }
}
