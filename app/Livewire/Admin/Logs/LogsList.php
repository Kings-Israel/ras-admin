<?php

namespace App\Livewire\Admin\Logs;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class LogsList extends Component
{
    use WithPagination;

    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $logs = Activity::with('causer', 'subject')
                        ->when($this->search && $this->search != '', function ($query) {
                            $query->where('description', 'LIKE', '%'.$this->search.'%')
                                ->orWhereHas('causer', function ($query) {
                                    $query->where('causer_type', '=', 'App\\Models\\User')->where('first_name', 'LIKE', '%'.$this->search.'%');
                                })
                                ->orWhereHas('subject', function ($query) {
                                    $query->where('subject_type', '=', 'App\\Models\\Product')->where('name', 'LIKE', '%'.$this->search.'%');
                                });
                        })
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);

        return view('livewire.admin.logs.logs-list', compact('logs'));
    }
}
