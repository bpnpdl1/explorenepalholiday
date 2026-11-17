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
            <x-admin::stat-card label="In progress" :value="$activeCount" change="Follow-up required" icon="ri-time-line" tone="warning" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Converted" :value="$convertedCount" change="Created bookings" icon="ri-checkbox-circle-line" tone="success" />
        </div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">All inquiries</h4>
                <p class="text-muted mb-0">Review traveler questions by follow-up stage.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $selectedStatus ? $visibleInquiryCount.' of ' : '' }}{{ $inquiryCount }} records</span>
        </div>

        <div class="card-body">
            <div class="row g-2 mb-3">
                <div class="col-md-5 col-lg-4">
                    <div class="search-box">
                        <input type="search" class="form-control search" id="inquiry-search" placeholder="Search inquiries..." aria-label="Search inquiries">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <select class="form-select" id="inquiry-stage-filter" aria-label="Filter inquiries by stage">
                        <option value="">All stages</option>
                        @foreach ($stageFilters as $status)
                            <option value="{{ $status }}" @selected($selectedStatus === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0" id="inquiries-table">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Inquiry ID</th>
                            <th scope="col">Traveler</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Interested package</th>
                            <th scope="col">Travel date</th>
                            <th scope="col">Travelers</th>
                            <th scope="col">Received</th>
                            <th scope="col">Stage</th>
                            <th scope="col" class="text-end">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inquiries as $inquiry)
                            <tr data-inquiry-row data-status="{{ $inquiry['status'] }}">
                                <td><span class="fw-medium">#{{ $inquiry['reference'] }}</span></td>
                                <td><h6 class="mb-1">{{ $inquiry['customer'] }}</h6><span class="text-muted">{{ $inquiry['email'] }}</span></td>
                                <td>{{ $inquiry['phone'] }}</td>
                                <td>{{ $inquiry['package'] }}</td>
                                <td>{{ $inquiry['travel_period'] }}</td>
                                <td>{{ $inquiry['travelers'] }}</td>
                                <td>{{ $inquiry['received'] }}</td>
                                <td><span class="badge bg-{{ $statusClasses[$inquiry['status']] }}-subtle text-{{ $statusClasses[$inquiry['status']] }}">{{ $inquiry['status'] }}</span></td>
                                <td class="text-end">
                                    <button class="btn btn-soft-primary btn-sm" type="button" data-inquiry-details aria-label="View inquiry {{ $inquiry['reference'] }}">
                                        <i class="ri-eye-line align-bottom"></i>
                                    </button>
                                    <span class="d-none" data-inquiry-message>{{ $inquiry['message'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                        <tr id="inquiry-empty-state" class="d-none">
                            <td colspan="9" class="text-center py-4 text-muted">No inquiries match these filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('admin/js/inquiries.init.js') }}"></script>
    @endpush
</x-admin-layouts::app>
