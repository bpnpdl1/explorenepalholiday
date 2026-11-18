<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Profile details</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input id="name" name="name" type="text" value="{{ old('name', $teamMember->name) }}" class="form-control @error('name') is-invalid @enderror" maxlength="255" required autofocus>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                        <input id="role" name="role" type="text" value="{{ old('role', $teamMember->role) }}" class="form-control @error('role') is-invalid @enderror" maxlength="255" placeholder="e.g. Trekking guide" required>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="bio" class="form-label">Bio</label>
                        <textarea id="bio" name="bio" rows="5" maxlength="5000" class="form-control @error('bio') is-invalid @enderror" placeholder="A short introduction to this team member...">{{ old('bio', $teamMember->bio) }}</textarea>
                        @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Portrait</h5></div>
                <div class="card-body">
                    @if ($teamMember->getFirstMediaUrl('portrait'))
                        <img src="{{ $teamMember->getFirstMediaUrl('portrait') }}" alt="Current portrait for {{ $teamMember->name }}" class="img-fluid rounded mb-3" style="max-height: 240px;">
                        <div class="form-check mb-3">
                            <input type="hidden" name="remove_portrait" value="0">
                            <input id="remove_portrait" name="remove_portrait" type="checkbox" value="1" class="form-check-input" @checked(old('remove_portrait'))>
                            <label for="remove_portrait" class="form-check-label">Remove current portrait</label>
                        </div>
                    @endif
                    <input id="portrait_image" name="portrait_image" type="file" accept="image/jpeg,image/png,image/webp,image/avif" class="form-control @error('portrait_image') is-invalid @enderror">
                    <div class="form-text">JPG, PNG, WebP, or AVIF. Maximum size: 5 MB. Uploading a new portrait replaces the current one.</div>
                    @error('portrait_image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Visibility and order</h5></div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="is_published" value="0">
                        <input id="is_published" name="is_published" type="checkbox" value="1" class="form-check-input" @checked(old('is_published', $teamMember->is_published))>
                        <label for="is_published" class="form-check-label">Published</label>
                        <div class="form-text">Published profiles appear on the public Our Team page.</div>
                    </div>
                    <div>
                        <label for="sort_order" class="form-label">Display order</label>
                        <input id="sort_order" name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $teamMember->sort_order ?? 0) }}" class="form-control @error('sort_order') is-invalid @enderror" required>
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ route('admin.team-members.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</form>
