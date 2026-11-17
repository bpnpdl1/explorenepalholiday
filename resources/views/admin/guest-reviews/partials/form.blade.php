<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Review details</h5></div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label for="reviewer_name" class="form-label">Guest name <span class="text-danger">*</span></label>
                            <input id="reviewer_name" name="reviewer_name" type="text" value="{{ old('reviewer_name', $review->reviewer_name) }}" class="form-control @error('reviewer_name') is-invalid @enderror" maxlength="255" required autofocus>
                            @error('reviewer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="reviewer_initials" class="form-label">Avatar initials</label>
                            <input id="reviewer_initials" name="reviewer_initials" type="text" value="{{ old('reviewer_initials', $review->reviewer_initials) }}" class="form-control @error('reviewer_initials') is-invalid @enderror" maxlength="10" placeholder="e.g. AB">
                            @error('reviewer_initials')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="trip_name" class="form-label">Trip or experience</label>
                            <input id="trip_name" name="trip_name" type="text" value="{{ old('trip_name', $review->trip_name) }}" class="form-control @error('trip_name') is-invalid @enderror" maxlength="255">
                            @error('trip_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="region_name" class="form-label">Region</label>
                            <input id="region_name" name="region_name" type="text" value="{{ old('region_name', $review->region_name) }}" class="form-control @error('region_name') is-invalid @enderror" maxlength="255">
                            @error('region_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="review_text" class="form-label">Review <span class="text-danger">*</span></label>
                            <textarea id="review_text" name="review_text" rows="8" maxlength="100000" class="form-control @error('review_text') is-invalid @enderror" required>{{ old('review_text', $review->review_text) }}</textarea>
                            @error('review_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Rating and source</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                        <select id="rating" name="rating" class="form-select @error('rating') is-invalid @enderror" required>
                            @for ($rating = 5; $rating >= 1; $rating--)
                                <option value="{{ $rating }}" @selected((int) old('rating', $review->rating ?? 5) === $rating)>{{ $rating }} {{ $rating === 1 ? 'star' : 'stars' }}</option>
                            @endfor
                        </select>
                        @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="reviewed_at" class="form-label">Review date</label>
                        <input id="reviewed_at" name="reviewed_at" type="date" value="{{ old('reviewed_at', $review->reviewed_at?->format('Y-m-d')) }}" class="form-control @error('reviewed_at') is-invalid @enderror">
                        @error('reviewed_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="source_url" class="form-label">Original review URL</label>
                        <input id="source_url" name="source_url" type="url" value="{{ old('source_url', $review->source_url) }}" class="form-control @error('source_url') is-invalid @enderror" maxlength="2048" placeholder="https://...">
                        @error('source_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ route('admin.guest-reviews.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</form>
