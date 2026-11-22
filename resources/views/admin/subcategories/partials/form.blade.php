<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Subcategory details</h5></div>
                <div class="card-body">
                    @if ($categories->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            Create a category before adding a subcategory. <a href="{{ route('admin.categories.create') }}" class="alert-link">Add a category</a>.
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Parent category <span class="text-danger">*</span></label>
                        <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required @disabled($categories->isEmpty())>
                            <option value="">Choose a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('category_id', $subcategory->category_id) === (string) $category->id)>{{ $category->destination->name }} · {{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Subcategory name <span class="text-danger">*</span></label>
                        <input id="name" name="name" type="text" value="{{ old('name', $subcategory->name) }}" class="form-control @error('name') is-invalid @enderror" maxlength="255" required autofocus>
                        <div class="form-text">A URL slug is generated automatically from this name.</div>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="summary" class="form-label">Short summary</label>
                        <textarea id="summary" name="summary" rows="3" maxlength="2000" class="form-control @error('summary') is-invalid @enderror" placeholder="A short introduction for subcategory cards.">{{ old('summary', $subcategory->summary) }}</textarea>
                        @error('summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" rows="8" maxlength="100000" class="form-control @error('description') is-invalid @enderror" placeholder="Describe what travelers can experience in this subcategory...">{{ old('description', $subcategory->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Visibility and order</h5></div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="is_featured" value="0">
                        <input id="is_featured" name="is_featured" type="checkbox" value="1" class="form-check-input" @checked(old('is_featured', $subcategory->is_featured))>
                        <label for="is_featured" class="form-check-label">Featured</label>
                        <div class="form-text">Featured subcategories are prioritized in the homepage trip-area section.</div>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="is_published" value="0">
                        <input id="is_published" name="is_published" type="checkbox" value="1" class="form-check-input" @checked(old('is_published', $subcategory->is_published))>
                        <label for="is_published" class="form-check-label">Published</label>
                        <div class="form-text">Published subcategories can be shown to travelers.</div>
                    </div>
                    <div>
                        <label for="sort_order" class="form-label">Display order</label>
                        <input id="sort_order" name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $subcategory->sort_order ?? 0) }}" class="form-control @error('sort_order') is-invalid @enderror" required>
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ route('admin.subcategories.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary" @disabled($categories->isEmpty())><i class="ri-save-line me-1"></i>{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</form>
