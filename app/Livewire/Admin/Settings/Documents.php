<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Country;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Documents extends Component
{
    use WithPagination;

    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createDocument(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'iso' => 'required',
        ]);

        Document::create($request->all());

        toastr()->success('', 'Document created successfully');

        return redirect()->route('settings.index');
    }

    public function updateDocument(Request $request, Document $document)
    {
        $request->validate([
            'name' => 'required',
            'iso' => 'required',
        ]);

        $document->update($request->all());

        toastr()->success('', 'Document updated successfully');

        return redirect()->route('settings.index');
    }

    public function deleteDocument(Request $request)
    {
        $request->validate([
            'Document_id' => 'required',
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            toastr()->error('', 'Cannot perform this action. Invalid password');

            return back();
        }

        Document::destroy($request->Document_id);

        toastr()->success('', 'Document deleted successfully');

        return redirect()->route('settings.index');
    }

    public function render()
    {
        $documents = Document::withCount('countries')
                            ->with('countries')
                            ->when($this->search && $this->search != '', function ($query) {
                                $query->where('name', 'LIKE', '%'.$this->search.'%');
                            })
                            ->paginate(5);

        $countries = Country::orderBy('name', 'ASC')->get();

        return view('livewire.admin.settings.documents', [
            'countries' => $countries,
            'documents' => $documents
        ]);
    }
}
