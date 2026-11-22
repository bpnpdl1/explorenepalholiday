<x-admin-layouts::app :title="__('FAQs')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">FAQs</h4>
                    <p class="text-muted mb-0 mt-1">Manage the questions and answers shown to travelers.</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <ol class="breadcrumb m-0 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">FAQs</li>
                    </ol>
                    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Add FAQ</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
        <div class="col"><x-admin::stat-card label="Total FAQs" :value="$faqCount" change="All records" icon="ri-question-answer-line" tone="primary" /></div>
        <div class="col"><x-admin::stat-card label="Published" :value="$publishedCount" change="Visible to travelers" icon="ri-checkbox-circle-line" tone="success" /></div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">All FAQs</h4>
                <p class="text-muted mb-0">Search questions and answers, or filter by publication status.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $faqs->total() }} FAQs</span>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.faqs.index') }}" class="row g-2 mb-3">
                <div class="col-md-6 col-lg-5">
                    <label class="visually-hidden" for="faq-search">Search FAQs</label>
                    <div class="search-box">
                        <input id="faq-search" type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search questions or answers...">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <label class="visually-hidden" for="faq-status">Filter by status</label>
                    <select id="faq-status" name="status" class="form-select">
                        <option value="">All statuses</option>
                        <option value="published" @selected($status === 'published')>Published</option>
                        <option value="draft" @selected($status === 'draft')>Draft</option>
                    </select>
                </div>
                <div class="col-md-2 col-lg-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    @if ($search !== '' || $status !== '')
                        <a href="{{ route('admin.faqs.index') }}" class="btn btn-light">Clear</a>
                    @endif
                </div>
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Question and answer</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Order</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($faqs as $faq)
                            <tr>
                                <td style="min-width: 300px; max-width: 620px; white-space: normal;">
                                    <div class="fw-medium">{{ $faq->question }}</div>
                                    <small class="text-muted">{{ \Illuminate\Support\Str::limit($faq->answer, 180) }}</small>
                                </td>
                                <td>{{ $faq->categoryEnum()->label() }}</td>
                                <td>{{ $faq->sort_order }}</td>
                                <td><span class="badge bg-{{ $faq->is_published ? 'success' : 'warning' }}-subtle text-{{ $faq->is_published ? 'success' : 'warning' }}">{{ $faq->is_published ? 'Published' : 'Draft' }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-soft-primary btn-sm" aria-label="Edit FAQ: {{ $faq->question }}"><i class="ri-pencil-line align-bottom"></i></a>
                                    <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this FAQ? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-soft-danger btn-sm" aria-label="Delete FAQ: {{ $faq->question }}"><i class="ri-delete-bin-line align-bottom"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted">No FAQs found. <a href="{{ route('admin.faqs.create') }}">Add your first FAQ</a>.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($faqs->hasPages())
                <div class="mt-3">{{ $faqs->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>
</x-admin-layouts::app>
