<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Page details</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Page title <span class="text-danger">*</span></label>
                        <input id="title" name="title" type="text" value="{{ old('title', $travelInfoPage->title) }}" class="form-control @error('title') is-invalid @enderror" maxlength="255" required autofocus>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">URL slug <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">/travel-info/</span>
                            <input id="slug" name="slug" type="text" value="{{ old('slug', $travelInfoPage->slug) }}" class="form-control @error('slug') is-invalid @enderror" maxlength="255" pattern="[A-Za-z0-9_-]+" required>
                            @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-text">Use lowercase words separated by hyphens, for example <code>best-time-to-visit</code>.</div>
                    </div>
                    @php($contentValue = app(\App\Services\RichContentSanitizer::class)->sanitize(old('content', $travelInfoPage->content)))
                    <x-admin::rich-editor
                        name="content"
                        label="Page content"
                        :value="$contentValue"
                        placeholder="Write useful travel information for visitors..."
                        maxlength="100000"
                        help="Use headings, text, lists, links, tables, photos, and video embeds. Content is sanitized before it is saved."
                    />
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Visibility and order</h5></div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="is_published" value="0">
                        <input id="is_published" name="is_published" type="checkbox" value="1" class="form-check-input" @checked(old('is_published', $travelInfoPage->is_published))>
                        <label for="is_published" class="form-check-label">Published</label>
                        <div class="form-text">Published pages appear in the public Travel Info menu.</div>
                    </div>
                    <div>
                        <label for="sort_order" class="form-label">Menu order</label>
                        <input id="sort_order" name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $travelInfoPage->sort_order ?? 0) }}" class="form-control @error('sort_order') is-invalid @enderror" required>
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ route('admin.travel-info-pages.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</form>
