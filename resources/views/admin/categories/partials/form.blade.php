<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Category details</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="destination_id" class="form-label">Destination <span class="text-danger">*</span></label>
                        <select id="destination_id" name="destination_id" class="form-select @error('destination_id') is-invalid @enderror" required>
                            <option value="">Choose a destination</option>
                            @foreach ($destinations as $destination)
                                <option value="{{ $destination->id }}" @selected((string) old('destination_id', $category->destination_id) === (string) $destination->id)>{{ $destination->name }}</option>
                            @endforeach
                        </select>
                        @error('destination_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Category name <span class="text-danger">*</span></label>
                        <input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" class="form-control @error('name') is-invalid @enderror" maxlength="255" required autofocus>
                        <div class="form-text">A URL slug is generated automatically from this name.</div>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="summary" class="form-label">Short summary</label>
                        <textarea id="summary" name="summary" rows="3" maxlength="2000" class="form-control @error('summary') is-invalid @enderror" placeholder="A short introduction for category cards.">{{ old('summary', $category->summary) }}</textarea>
                        @error('summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" rows="8" maxlength="100000" class="form-control @error('description') is-invalid @enderror" placeholder="Describe what travelers can experience in this category...">{{ old('description', $category->description) }}</textarea>
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
                        <input type="hidden" name="is_published" value="0">
                        <input id="is_published" name="is_published" type="checkbox" value="1" class="form-check-input" @checked(old('is_published', $category->is_published))>
                        <label for="is_published" class="form-check-label">Published</label>
                        <div class="form-text">Published categories can be shown to travelers.</div>
                    </div>
                    <div>
                        <label for="sort_order" class="form-label">Display order</label>
                        <input id="sort_order" name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="form-control @error('sort_order') is-invalid @enderror" required>
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</form>
