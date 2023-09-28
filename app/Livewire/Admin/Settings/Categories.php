<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;

    public $search;
    public $name;
    public $id;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createCategory(Request $request)
    {
        $this->validate([
            'name' => 'required',
        ]);

        Category::create([
            'name' => $this->name
        ]);

        toastr()->success('', 'Category created successfully');

        return redirect()->route('settings.index');
    }

    public function edit(Category $category)
    {
        $this->id = $category->id;
        $this->name = $category->name;
    }

    public function updateCategory(Request $request)
    {
        $this->validate([
            'id' => 'required',
            'name' => 'required',
        ]);

        Category::find($request->id)->update($request->all());

        toastr()->success('', 'Category updated successfully');

        return redirect()->route('settings.index');
    }

    public function deleteCategory(Request $request)
    {
        $request->validate([
            'Category_id' => 'required',
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            toastr()->error('', 'Cannot perform this action. Invalid password');

            return back();
        }

        Category::destroy($request->Category_id);

        toastr()->success('', 'Country deleted successfully');

        return redirect()->route('settings.index');
    }

    public function render()
    {
        $categories = Category::withCount('products')
                                ->when($this->search && $this->search != '', function ($query) {
                                    $query->where('name', 'LIKE', '%'.$this->search.'%');
                                })
                                ->paginate(5);

        return view('livewire.admin.settings.categories', [
            'categories' => $categories
        ]);
    }
}
