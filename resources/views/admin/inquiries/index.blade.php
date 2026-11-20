<x-admin-layouts::app :title="__('Inquiries')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Inquiries</h4>
                    <p class="text-muted mb-0 mt-1">Follow up with travelers and turn trip questions into bookings.</p>
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
            <span class="badge bg-primary-subtle text-primary">{{ $inquiries->total() }}{{ $selectedStatus || $search !== '' ? ' of '.$inquiryCount : '' }} records</span>
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
                <div class="col-auto"><button class="btn btn-primary" type="submit">Filter</button></div>
                @if ($selectedStatus || $search !== '')
                    <div class="col-auto"><a class="btn btn-light" href="{{ route('admin.inquiries.index') }}">Clear</a></div>
                @endif
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0" id="inquiries-table">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Inquiry ID</th>
                            <th scope="col">Traveler</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Interested package</th>
                            <th scope="col">Travel date</th>
                            <th scope="col">Received</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inquiries as $inquiry)
                            <tr>
                                <td><span class="fw-medium">#{{ $inquiry->id }}</span></td>
                                <td><h6 class="mb-1">{{ $inquiry->customer_name }}</h6><span class="text-muted">{{ $inquiry->email }}</span></td>
                                <td>{{ $inquiry->phone }}</td>
                                <td>{{ $inquiry->package?->name ?? 'Package removed' }}</td>
                                <td>{{ $inquiry->travelWindowLabel() }}</td>
                                <td>{{ $inquiry->created_at->format('M j, Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $statusClasses[$inquiry->status->value] }}-subtle text-{{ $statusClasses[$inquiry->status->value] }}">{{ $inquiry->status->label() }}</span>
                                    <form method="POST" action="{{ route('admin.inquiries.update-status', $inquiry) }}" class="d-flex gap-1 mt-2">
                                        @csrf
                                        @method('PATCH')
                                        <label class="visually-hidden" for="inquiry-status-{{ $inquiry->id }}">Update inquiry {{ $inquiry->id }} status</label>
                                        <select class="form-select form-select-sm" id="inquiry-status-{{ $inquiry->id }}" name="status">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->value }}" @selected($status === $inquiry->status)>{{ $status->label() }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-sm btn-light" type="submit" aria-label="Save status for inquiry {{ $inquiry->id }}"><i class="ri-save-line" aria-hidden="true"></i></button>
                                    </form>
                                </td>
                                <td class="text-end">
                                    <a class="btn btn-soft-primary btn-sm" href="{{ route('admin.inquiries.show', $inquiry) }}" aria-label="View inquiry {{ $inquiry->id }}">
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
