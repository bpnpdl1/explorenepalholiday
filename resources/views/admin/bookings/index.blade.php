<x-admin-layouts::app :title="__('Bookings')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Bookings</h4>
                    <p class="text-muted mb-0 mt-1">Review trip requests and booking details.</p>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Bookings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 mb-3">
        <div class="col">
            <x-admin::stat-card label="Total bookings" :value="$bookingCount" value-id="booking-stat-total" change="All requests" icon="ri-calendar-check-line" tone="primary" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Confirmed" :value="$confirmedCount" value-id="booking-stat-confirmed" change="Ready for travel" icon="ri-checkbox-circle-line" tone="success" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Needs attention" :value="$awaitingCount" value-id="booking-stat-attention" change="Payment or review" icon="ri-time-line" tone="warning" />
        </div>
        <div class="col">
            <x-admin::stat-card label="New inquiries" :value="$inquiryCount" value-id="booking-stat-inquiries" change="Awaiting response" icon="ri-question-answer-line" tone="info" />
        </div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">All bookings</h4>
                <p class="text-muted mb-0">Track each request through its booking stage.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $selectedStatus ? $visibleBookingCount.' of ' : '' }}{{ $bookingCount }} records</span>
        </div>

        <div class="card-body">
            <div class="row g-2 mb-3">
                <div class="col-md-5 col-lg-4">
                    <div class="search-box">
                        <input type="search" class="form-control search" id="booking-search" placeholder="Search bookings..." aria-label="Search bookings">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <select class="form-select" id="booking-stage-filter" aria-label="Filter bookings by stage">
                        <option value="">All stages</option>
                        @foreach ($stageFilters as $status)
                            <option value="{{ $status }}" @selected($selectedStatus === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0" id="bookings-table">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Booking ID</th>
                            <th scope="col">Traveler</th>
                            <th scope="col">Package</th>
                            <th scope="col">Travel date</th>
                            <th scope="col">Guests</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr data-booking-row data-status="{{ $booking['status'] }}">
                                <td><span class="fw-medium">#{{ $booking['reference'] }}</span></td>
                                <td>
                                    <h6 class="mb-1">{{ $booking['customer'] }}</h6>
                                    <span class="text-muted">{{ $booking['email'] }}</span>
                                </td>
                                <td>{{ $booking['package'] }}</td>
                                <td>{{ $booking['travel_date'] }}</td>
                                <td>{{ $booking['guests'] }}</td>
                                <td class="fw-medium">{{ $booking['total'] }}</td>
                                <td><span class="badge bg-{{ $statusClasses[$booking['status']] }}-subtle text-{{ $statusClasses[$booking['status']] }}" data-booking-status>{{ $booking['status'] }}</span></td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-soft-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Actions for booking {{ $booking['reference'] }}">
                                            <i class="ri-more-fill align-bottom"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button class="dropdown-item" type="button" data-booking-details>
                                                    <i class="ri-eye-line me-2 align-bottom text-muted"></i>View details
                                                </button>
                                            </li>
                                            @foreach ($stageActions[$booking['status']] ?? [] as $action)
                                                <li>
                                                    <button
                                                        class="dropdown-item {{ ($action['danger'] ?? false) ? 'text-danger' : '' }}"
                                                        type="button"
                                                        data-booking-transition
                                                        data-next-status="{{ $action['next_status'] }}"
                                                        data-confirm="{{ $action['confirm'] }}"
                                                    >
                                                        <i class="{{ ($action['danger'] ?? false) ? 'ri-close-circle-line' : 'ri-arrow-right-line' }} me-2 align-bottom"></i>{{ $action['label'] }}
                                                    </button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr id="booking-empty-state" class="d-none">
                            <td colspan="8" class="text-center py-4 text-muted">No bookings match these filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            window.adminBookingStageActions = {{ Illuminate\Support\Js::from($stageActions) }};
            window.adminBookingStatusClasses = {{ Illuminate\Support\Js::from($statusClasses) }};
        </script>
        <script src="{{ asset('admin/js/bookings.init.js') }}"></script>
    @endpush
</x-admin-layouts::app>
