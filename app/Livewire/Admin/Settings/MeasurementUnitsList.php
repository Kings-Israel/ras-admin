<?php

namespace App\Livewire\Admin\Settings;

use App\Models\MeasurementUnit;
use Livewire\Component;
use Livewire\WithPagination;

class MeasurementUnitsList extends Component
{
    use WithPagination;

    public $search;
    public $name;
    public $abbrev;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createUnit()
    {
        $this->validate([
            'name' => 'required',
        ]);

        MeasurementUnit::create([
            'name' => $this->name,
            'abbrev' => $this->abbrev
        ]);

        toastr()->success('', 'Unit added successfully');

        return redirect()->route('settings.index');
    }

    public function render()
    {
        $units = MeasurementUnit::when($this->search && $this->search != '', function ($query) {
                                    $query->where('name', 'LIKE', '%'.$this->search.'%');
                                })
                                ->paginate(5);

        return view('livewire.admin.settings.measurement-units-list', compact('units'));
    }
}
