<div class="card">
    <div class="header">
        <div class="d-flex justify-content-between">
            <h2 class="my-auto"><strong>Product Categories</strong></h2>
            <a class="btn btn-secondary btn-sm" href="#" data-toggle="modal" data-target="#addCategories">Add Category</a>
        </div>
        <div class="modal fade" id="addCategories" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="addCategoriesLabel">Add Product Category</h4>
                    </div>
                    <form action="#" method="POST" wire:submit="createCategory">
                        @csrf
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-12">
                                    <label for="role_name">Name</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Name" name="name" wire:model="name" :value="old('name')" required autocomplete="off" />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2 list-unstyled"></x-input-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-round waves-effect">SAVE</button>
                            <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="body table-responsive">
        <div class="row">
            <div class="col-3">
                <input type="text" class="form-control" wire:model.live="search" placeholder="Search Category">
            </div>
        </div>
        <table class="table m-b-0">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>NO. OF PRODUCTS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ Str::title($category->name) }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>
                            <div class="flex mx-2">
                                <a href="#editCategories_{{ $category->id }}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editCategories_{{ $category->id }}">Edit</a>
                                {{-- <a href="#" class="btn btn-warning btn-sm">Edit</a> --}}
                                <a href="#deleteCategories_{{ $category->id }}" data-toggle="modal" data-target="#deleteCategories_{{ $category->id }}">
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @include('partials.admin.settings.edit-category')
                    @include('partials.admin.settings.delete-category')
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $categories->links() }}
        </div>
    </div>
</div>
