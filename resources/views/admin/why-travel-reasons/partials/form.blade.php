<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Card content</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input id="title" name="title" type="text" value="{{ old('title', $reason->title) }}" class="form-control @error('title') is-invalid @enderror" maxlength="255" required autofocus>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea id="description" name="description" rows="6" maxlength="5000" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $reason->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Icon image</h5></div>
                <div class="card-body">
                    @if ($reason->getFirstMediaUrl('icon'))
                        <img src="{{ $reason->getFirstMediaUrl('icon') }}" alt="Current icon for {{ $reason->title }}" class="rounded mb-3" width="72" height="72" style="object-fit: contain;">
                    @endif
                    <input id="icon_image" name="icon_image" type="file" accept="image/jpeg,image/png,image/webp,image/avif" class="form-control @error('icon_image') is-invalid @enderror" @required(! $reason->exists)>
                    <div class="form-text">JPG, PNG, WebP, or AVIF. Maximum size: 5 MB. Uploading a new icon replaces the current one.</div>
                    @error('icon_image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Visibility and order</h5></div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="is_published" value="0">
                        <input id="is_published" name="is_published" type="checkbox" value="1" class="form-check-input" @checked(old('is_published', $reason->is_published))>
                        <label for="is_published" class="form-check-label">Published</label>
                        <div class="form-text">Published reasons appear on the homepage.</div>
                    </div>
                    <div>
                        <label for="sort_order" class="form-label">Display order</label>
                        <input id="sort_order" name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $reason->sort_order ?? 0) }}" class="form-control @error('sort_order') is-invalid @enderror" required>
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ route('admin.why-travel-reasons.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</form>
