<x-admin-layouts::app :title="__('About Us page')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">About Us page</h4>
                    <p class="text-muted mb-0 mt-1">Edit all About Us page content in the rich text editor.</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <ol class="breadcrumb m-0 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">About Us page</li>
                    </ol>
                    <a href="{{ route('about') }}" class="btn btn-light" target="_blank" rel="noopener noreferrer">View page <i class="ri-external-link-line ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.about-page.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-1">Page content</h5>
                <p class="text-muted mb-0">Use headings, text, lists, links, tables, photos, and video embeds. The complete page body is stored as one editable record.</p>
            </div>
            <div class="card-body">
                @php($contentValue = app(\App\Services\RichContentSanitizer::class)->sanitize(old('content', $aboutPage->content)))
                <x-admin::rich-editor
                    name="content"
                    label="About Us page content"
                    :value="$contentValue"
                    placeholder="Write the About Us page content..."
                    maxlength="100000"
                    help="Changes appear on the public About Us page after saving. Images are uploaded through the editor."
                />
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>Save About Us page</button>
            </div>
        </div>
    </form>
</x-admin-layouts::app>
