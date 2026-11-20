<x-admin-layouts::app :title="__('Inquiries')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Inquiries</h4>
                <p class="text-muted mb-0 mt-1">Package requests and messages from the website, together in one follow-up queue.</p>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Inquiries</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 mb-3">
        <div class="col">
            <x-admin::stat-card label="Total inquiries" :value="$inquiryCount" change="All requests" icon="ri-question-answer-line" tone="primary" />
        </div>
        <div class="col">
            <x-admin::stat-card label="New" :value="$newCount" change="Need first response" icon="ri-mail-unread-line" tone="info" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Contacted" :value="$contactedCount" change="Follow-up started" icon="ri-phone-line" tone="success" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Cancelled" :value="$cancelledCount" change="Closed inquiries" icon="ri-close-circle-line" tone="secondary" />
        </div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">All inquiries</h4>
                <p class="text-muted mb-0">Review traveler questions by follow-up stage.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $inquiries->total() }}{{ $selectedStatus || $selectedSource || $search !== '' ? ' of '.$inquiryCount : '' }} records</span>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('admin.inquiries.index') }}" class="row g-2 mb-3">
                <div class="col-md-5 col-lg-4">
                    <div class="search-box">
                        <input type="search" class="form-control" id="inquiry-search" name="search" value="{{ $search }}" placeholder="Search inquiries..." aria-label="Search inquiries">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <select class="form-select" id="inquiry-stage-filter" name="status" aria-label="Filter inquiries by status">
                        <option value="">All statuses</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" @selected($selectedStatus === $status)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-lg-2">
                    <select class="form-select" name="source" aria-label="Filter inquiries by source">
                        <option value="">All sources</option>
                        <option value="package" @selected($selectedSource === 'package')>Package inquiries</option>
                        <option value="website" @selected($selectedSource === 'website')>Website inquiries</option>
                    </select>
                </div>
                <div class="col-auto"><button class="btn btn-primary" type="submit">Filter</button></div>
                @if ($selectedStatus || $selectedSource || $search !== '')
                    <div class="col-auto"><a class="btn btn-light" href="{{ route('admin.inquiries.index') }}">Clear</a></div>
                @endif
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0" id="inquiries-table">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Inquiry ID</th>
                            <th scope="col">Source</th>
                            <th scope="col">Traveler</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Interest / package</th>
                            <th scope="col">Received</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inquiries as $inquiry)
                            <tr>
                                <td><span class="fw-medium">#{{ $inquiry->id }}</span></td>
                                <td><span class="badge bg-{{ $inquiry->source === 'package' ? 'primary' : 'info' }}-subtle text-{{ $inquiry->source === 'package' ? 'primary' : 'info' }}">{{ $inquiry->source === 'package' ? 'Package' : 'Website' }}</span></td>
                                <td><h6 class="mb-1">{{ $inquiry->name }}</h6><span class="text-muted">{{ $inquiry->email }}</span></td>
                                <td>{{ $inquiry->phone ?: '—' }}</td>
                                <td>
                                    @if ($inquiry->source === 'package')
                                        {{ $inquiry->package_name ?? 'Package removed' }}
                                    @else
                                        {{ $inquiry->interest ?: 'General question' }}
                                    @endif
                                </td>
                                <td>{{ \Illuminate\Support\Carbon::parse($inquiry->created_at)->format('M j, Y') }}</td>
                                <td><span class="badge bg-{{ $statusClasses[$inquiry->status] }}-subtle text-{{ $statusClasses[$inquiry->status] }}">{{ \App\Enums\PackageInquiryStatus::from($inquiry->status)->label() }}</span></td>
                                <td class="text-end">
                                    <a class="btn btn-soft-primary btn-sm" href="{{ $inquiry->source === 'package' ? route('admin.inquiries.show', $inquiry->id) : route('admin.site-inquiries.show', $inquiry->id) }}" aria-label="View inquiry {{ $inquiry->id }}">
                                        <i class="ri-eye-line align-bottom" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No inquiries have been submitted yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $inquiries->links() }}</div>
        </div>
    </div>

</x-admin-layouts::app>
