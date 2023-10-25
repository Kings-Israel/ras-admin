<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RolesList extends Component
{
    use WithPagination;

    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $roles = Role::withCount('permissions', 'users')
                        ->where('name', '!=', 'admin')
                        ->when($this->search && $this->search != '', function ($query) {
                            $query->where('name', 'LIKE', '%'.$this->search.'%');
                        })
                        ->paginate(10);

        return view('livewire.admin.roles.roles-list', [
            'roles' => $roles
        ]);
    }
}
