<div class="modal fade" id="editCategories_{{ $category->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="editCategoriesLabel">Edit Product Category</h4>
            </div>
            <form action="{{ route('settings.category.update', ['category' => $category]) }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $category->id }}">
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-12">
                            <label for="role_name">Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $category->name }}" required autocomplete="off" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2 list-unstyled"></x-input-error>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-round waves-effect">UPDATE</button>
                    <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>
