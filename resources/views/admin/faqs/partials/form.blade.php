<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">FAQ details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                        <input id="question" name="question" type="text" value="{{ old('question', $faq->question) }}" class="form-control @error('question') is-invalid @enderror" maxlength="255" required autofocus>
                        @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="answer" class="form-label">Answer <span class="text-danger">*</span></label>
                        <textarea id="answer" name="answer" rows="10" maxlength="100000" class="form-control @error('answer') is-invalid @enderror" placeholder="Write a clear answer for travelers..." required>{{ old('answer', $faq->answer) }}</textarea>
                        <div class="form-text">Plain text answer. Line breaks are preserved on the public FAQ page.</div>
                        @error('answer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Visibility and order</h5>
                </div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="is_published" value="0">
                        <input id="is_published" name="is_published" type="checkbox" value="1" class="form-check-input" @checked(old('is_published', $faq->is_published))>
                        <label for="is_published" class="form-check-label">Published</label>
                        <div class="form-text">Published FAQs can be shown on the public website.</div>
                    </div>
                    <div>
                        <label for="sort_order" class="form-label">Display order</label>
                        <input id="sort_order" name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $faq->sort_order ?? 0) }}" class="form-control @error('sort_order') is-invalid @enderror" required>
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</form>
