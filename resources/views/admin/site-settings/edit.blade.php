<x-admin-layouts::app :title="__('Site settings')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Site settings</h4>
                    <p class="text-muted mb-0 mt-1">Update your brand, contact details, and default SEO metadata.</p>
                </div>
                <ol class="breadcrumb m-0 d-none d-md-flex">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item active">Site settings</li>
                </ol>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Brand details</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Site name <span class="text-danger">*</span></label>
                            <input id="name" name="name" type="text" value="{{ old('name', $siteSetting->name) }}" class="form-control @error('name') is-invalid @enderror" maxlength="255" required autofocus>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="tagline" class="form-label">Tagline</label>
                            <input id="tagline" name="tagline" type="text" value="{{ old('tagline', $siteSetting->tagline) }}" class="form-control @error('tagline') is-invalid @enderror" maxlength="255">
                            @error('tagline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label for="description" class="form-label">Site description</label>
                            <textarea id="description" name="description" rows="4" maxlength="5000" class="form-control @error('description') is-invalid @enderror">{{ old('description', $siteSetting->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Contact details</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Contact email</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $siteSetting->email) }}" class="form-control @error('email') is-invalid @enderror" maxlength="255">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input id="phone" name="phone" type="tel" value="{{ old('phone', $siteSetting->phone) }}" class="form-control @error('phone') is-invalid @enderror" maxlength="50">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="whatsapp_number" class="form-label">WhatsApp number</label>
                                <input id="whatsapp_number" name="whatsapp_number" type="tel" value="{{ old('whatsapp_number', $siteSetting->whatsapp_number) }}" class="form-control @error('whatsapp_number') is-invalid @enderror" maxlength="50">
                                @error('whatsapp_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea id="address" name="address" rows="3" maxlength="2000" class="form-control @error('address') is-invalid @enderror">{{ old('address', $siteSetting->address) }}</textarea>
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Social links</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'tiktok' => 'TikTok', 'youtube' => 'YouTube'] as $key => $label)
                                <div class="col-md-6">
                                    <label for="social_links_{{ $key }}" class="form-label">{{ $label }} URL</label>
                                    <input id="social_links_{{ $key }}" name="social_links[{{ $key }}]" type="url" value="{{ old('social_links.'.$key, data_get($siteSetting->social_links, $key)) }}" class="form-control @error('social_links.'.$key) is-invalid @enderror" maxlength="2048" placeholder="https://...">
                                    @error('social_links.'.$key)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                @php($footerResources = old('footer_resources', $siteSetting->footer_resources ?? []))
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Footer travel resources</h5>
                        <p class="text-muted mb-0 mt-1">Manage the resource heading and the organizations displayed in the footer.</p>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="footer_resources_eyebrow" class="form-label">Eyebrow</label>
                                <input id="footer_resources_eyebrow" name="footer_resources_eyebrow" type="text" value="{{ old('footer_resources_eyebrow', $siteSetting->footer_resources_eyebrow) }}" class="form-control @error('footer_resources_eyebrow') is-invalid @enderror" maxlength="100" required>
                                @error('footer_resources_eyebrow')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-8">
                                <label for="footer_resources_title" class="form-label">Section title</label>
                                <input id="footer_resources_title" name="footer_resources_title" type="text" value="{{ old('footer_resources_title', $siteSetting->footer_resources_title) }}" class="form-control @error('footer_resources_title') is-invalid @enderror" maxlength="255" required>
                                @error('footer_resources_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="footer_resources_description" class="form-label">Description</label>
                                <textarea id="footer_resources_description" name="footer_resources_description" rows="2" maxlength="1000" class="form-control @error('footer_resources_description') is-invalid @enderror" required>{{ old('footer_resources_description', $siteSetting->footer_resources_description) }}</textarea>
                                @error('footer_resources_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Organizations</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-footer-resource"><i class="ri-add-line me-1"></i>Add organization</button>
                        </div>
                        <div id="footer-resource-list" class="d-grid gap-3">
                            @foreach ($footerResources as $index => $resource)
                                <div class="border rounded p-3 footer-resource-row">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <strong>Organization <span class="footer-resource-number">{{ $loop->iteration }}</span></strong>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-footer-resource" aria-label="Remove organization">Remove</button>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label" for="footer_resource_{{ $index }}_name">Name</label>
                                            <input id="footer_resource_{{ $index }}_name" name="footer_resources[{{ $index }}][name]" type="text" value="{{ $resource['name'] ?? '' }}" class="form-control @error('footer_resources.'.$index.'.name') is-invalid @enderror" maxlength="255" required>
                                            @error('footer_resources.'.$index.'.name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="footer_resource_{{ $index }}_url">Organization website</label>
                                            <input id="footer_resource_{{ $index }}_url" name="footer_resources[{{ $index }}][url]" type="url" value="{{ $resource['url'] ?? '' }}" class="form-control @error('footer_resources.'.$index.'.url') is-invalid @enderror" maxlength="2048" required>
                                            @error('footer_resources.'.$index.'.url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="footer_resource_{{ $index }}_logo">Logo path or image URL</label>
                                            <input id="footer_resource_{{ $index }}_logo" name="footer_resources[{{ $index }}][logo]" type="text" value="{{ $resource['logo'] ?? '' }}" class="form-control @error('footer_resources.'.$index.'.logo') is-invalid @enderror" maxlength="2048" required>
                                            <div class="form-text">Use a site path such as /site/assets/logo.svg or an HTTPS image URL.</div>
                                            @error('footer_resources.'.$index.'.logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="footer_resource_{{ $index }}_alt">Accessible image description</label>
                                            <input id="footer_resource_{{ $index }}_alt" name="footer_resources[{{ $index }}][alt]" type="text" value="{{ $resource['alt'] ?? '' }}" class="form-control @error('footer_resources.'.$index.'.alt') is-invalid @enderror" maxlength="255" required>
                                            @error('footer_resources.'.$index.'.alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('footer_resources')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Footer payment information</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="footer_payment_title" class="form-label">Section title</label>
                            <input id="footer_payment_title" name="footer_payment_title" type="text" value="{{ old('footer_payment_title', $siteSetting->footer_payment_title) }}" class="form-control @error('footer_payment_title') is-invalid @enderror" maxlength="100" required>
                            @error('footer_payment_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label for="footer_payment_description" class="form-label">Payment note</label>
                            <textarea id="footer_payment_description" name="footer_payment_description" rows="3" maxlength="1000" class="form-control @error('footer_payment_description') is-invalid @enderror" required>{{ old('footer_payment_description', $siteSetting->footer_payment_description) }}</textarea>
                            @error('footer_payment_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Default SEO metadata</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta title</label>
                            <input id="meta_title" name="meta_title" type="text" value="{{ old('meta_title', $siteSetting->meta_title) }}" class="form-control @error('meta_title') is-invalid @enderror" maxlength="255">
                            @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta description</label>
                            <textarea id="meta_description" name="meta_description" rows="3" maxlength="1000" class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description', $siteSetting->meta_description) }}</textarea>
                            @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="canonical_url" class="form-label">Canonical URL</label>
                            <input id="canonical_url" name="canonical_url" type="url" value="{{ old('canonical_url', $siteSetting->canonical_url) }}" class="form-control @error('canonical_url') is-invalid @enderror" maxlength="2048" placeholder="https://example.com/">
                            @error('canonical_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="og_title" class="form-label">Open Graph title</label>
                            <input id="og_title" name="og_title" type="text" value="{{ old('og_title', $siteSetting->og_title) }}" class="form-control @error('og_title') is-invalid @enderror" maxlength="255">
                            @error('og_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label for="og_description" class="form-label">Open Graph description</label>
                            <textarea id="og_description" name="og_description" rows="3" maxlength="1000" class="form-control @error('og_description') is-invalid @enderror">{{ old('og_description', $siteSetting->og_description) }}</textarea>
                            @error('og_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Site logo</h5></div>
                    <div class="card-body">
                        @if ($siteSetting->getFirstMediaUrl('logo'))
                            <img src="{{ $siteSetting->getFirstMediaUrl('logo') }}" alt="Current {{ $siteSetting->name }} logo" class="img-fluid rounded mb-3" style="max-height: 160px;">
                        @endif
                        <input id="logo" name="logo" type="file" accept="image/jpeg,image/png,image/webp,image/avif" class="form-control @error('logo') is-invalid @enderror">
                        <div class="form-text">JPG, PNG, WebP, or AVIF. Maximum size: 5 MB. Uploading a new logo replaces the current one.</div>
                        @error('logo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Favicon</h5></div>
                    <div class="card-body">
                        @if ($siteSetting->getFirstMediaUrl('favicon'))
                            <img src="{{ $siteSetting->getFirstMediaUrl('favicon') }}" alt="Current {{ $siteSetting->name }} favicon" class="rounded mb-3" width="64" height="64">
                        @endif
                        <input id="favicon" name="favicon" type="file" accept="image/png" class="form-control @error('favicon') is-invalid @enderror">
                        <div class="form-text">PNG only, 16×16 to 512×512 pixels. Maximum size: 2 MB. Uploading a new favicon replaces the current one.</div>
                        @error('favicon')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Footer logo</h5></div>
                    <div class="card-body">
                        @if ($siteSetting->getFirstMediaUrl('footer-logo'))
                            <img src="{{ $siteSetting->getFirstMediaUrl('footer-logo') }}" alt="Current {{ $siteSetting->name }} footer logo" class="img-fluid rounded mb-3" style="max-height: 160px;">
                        @endif
                        <input id="footer_logo" name="footer_logo" type="file" accept="image/jpeg,image/png,image/webp,image/avif" class="form-control @error('footer_logo') is-invalid @enderror">
                        <div class="form-text">JPG, PNG, WebP, or AVIF. Maximum size: 5 MB. This replaces the logo shown in the public site footer.</div>
                        @error('footer_logo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Payment logos</h5></div>
                    <div class="card-body">
                        <img src="{{ $siteSetting->getFirstMediaUrl('footer-payment-options') ?: asset('site/assets/pay-cards01.svg') }}" alt="Current footer payment logos" class="img-fluid rounded mb-3" style="max-height: 100px;">
                        <input id="footer_payment_options" name="footer_payment_options" type="file" accept="image/jpeg,image/png,image/webp,image/avif" class="form-control @error('footer_payment_options') is-invalid @enderror">
                        <div class="form-text">Optional JPG, PNG, WebP, or AVIF image. Maximum size: 5 MB. Leave empty to keep the current image.</div>
                        @error('footer_payment_options')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mb-4">
                    <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>Save settings</button>
                </div>
            </div>
        </div>
        <template id="footer-resource-template">
            <div class="border rounded p-3 footer-resource-row">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <strong>Organization <span class="footer-resource-number"></span></strong>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-footer-resource" aria-label="Remove organization">Remove</button>
                </div>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Name</label><input data-field="name" type="text" class="form-control" maxlength="255" required></div>
                    <div class="col-md-6"><label class="form-label">Organization website</label><input data-field="url" type="url" class="form-control" maxlength="2048" required></div>
                    <div class="col-md-6"><label class="form-label">Logo path or image URL</label><input data-field="logo" type="text" class="form-control" maxlength="2048" required><div class="form-text">Use a site path such as /site/assets/logo.svg or an HTTPS image URL.</div></div>
                    <div class="col-md-6"><label class="form-label">Accessible image description</label><input data-field="alt" type="text" class="form-control" maxlength="255" required></div>
                </div>
            </div>
        </template>
    </form>

@push('scripts')
    <script>
        (() => {
            const list = document.getElementById('footer-resource-list');
            const template = document.getElementById('footer-resource-template');
            const addButton = document.getElementById('add-footer-resource');

            if (!list || !template || !addButton) return;

            const renumber = () => list.querySelectorAll('.footer-resource-row').forEach((row, index) => {
                row.querySelectorAll('[data-field]').forEach((field) => {
                    field.name = `footer_resources[${index}][${field.dataset.field}]`;
                    field.id = `footer_resource_${index}_${field.dataset.field}`;
                    field.previousElementSibling?.setAttribute('for', field.id);
                });
                row.querySelector('.footer-resource-number').textContent = index + 1;
            });

            addButton.addEventListener('click', () => {
                if (list.querySelectorAll('.footer-resource-row').length >= 12) return;
                list.append(template.content.cloneNode(true));
                renumber();
            });

            list.addEventListener('click', (event) => {
                const button = event.target.closest('.remove-footer-resource');
                if (!button || list.querySelectorAll('.footer-resource-row').length <= 1) return;
                button.closest('.footer-resource-row').remove();
                renumber();
            });
        })();
    </script>
@endpush
</x-admin-layouts::app>
