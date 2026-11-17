<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Destination details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Destination name <span class="text-danger">*</span></label>
                        <input id="name" name="name" type="text" value="{{ old('name', $destination->name) }}" class="form-control @error('name') is-invalid @enderror" maxlength="255" required autofocus>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="region" class="form-label">Region</label>
                        <input id="region" name="region" type="text" value="{{ old('region', $destination->region) }}" class="form-control @error('region') is-invalid @enderror" maxlength="255" placeholder="e.g. Khumbu Region">
                        @error('region')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="summary" class="form-label">Short summary</label>
                        <textarea id="summary" name="summary" rows="3" maxlength="2000" class="form-control @error('summary') is-invalid @enderror" placeholder="A short introduction for destination cards.">{{ old('summary', $destination->summary) }}</textarea>
                        @error('summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    @php($descriptionValue = app(\App\Services\RichContentSanitizer::class)->sanitize(old('description', $destination->description)))
                    <x-admin::rich-editor
                        name="description"
                        label="Description"
                        :value="$descriptionValue"
                        placeholder="Describe the destination and what travelers can experience there..."
                        maxlength="100000"
                        help="Use headings, lists, links, tables, and inline images to format the destination description."
                    />
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Cover image</h5>
                </div>
                <div class="card-body">
                    @if ($destination->getFirstMediaUrl('cover'))
                        <img src="{{ $destination->getFirstMediaUrl('cover', 'thumbnail') ?: $destination->getFirstMediaUrl('cover') }}" alt="Current cover for {{ $destination->name }}" class="img-fluid rounded mb-3">
                    @endif
                    <input id="cover_image" name="cover_image" type="file" accept="image/jpeg,image/png,image/webp,image/avif" class="form-control @error('cover_image') is-invalid @enderror">
                    <div class="form-text">JPG, PNG, WebP, or AVIF. Maximum size: 5 MB. Uploading a new image replaces the current cover.</div>
                    @error('cover_image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Visibility and order</h5>
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="is_published" value="0">
                        <input id="is_published" name="is_published" type="checkbox" value="1" class="form-check-input" @checked(old('is_published', $destination->is_published))>
                        <label for="is_published" class="form-check-label">Published</label>
                        <div class="form-text">Published destinations can be shown on the public website.</div>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="is_featured" value="0">
                        <input id="is_featured" name="is_featured" type="checkbox" value="1" class="form-check-input" @checked(old('is_featured', $destination->is_featured))>
                        <label for="is_featured" class="form-check-label">Featured</label>
                    </div>
                    <div>
                        <label for="sort_order" class="form-label">Display order</label>
                        <input id="sort_order" name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $destination->sort_order ?? 0) }}" class="form-control @error('sort_order') is-invalid @enderror" required>
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ route('admin.destinations.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</form>
