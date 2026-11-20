<x-admin-layouts::app :title="__('Bookings')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Bookings</h4>
                    <p class="text-muted mb-0 mt-1">Review trip requests and move each booking through its status.</p>
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
        <div class="col"><x-admin::stat-card label="Total bookings" :value="$bookingCount" change="All requests" icon="ri-calendar-check-line" tone="primary" /></div>
        <div class="col"><x-admin::stat-card label="New" :value="$newCount" change="Awaiting review" icon="ri-question-answer-line" tone="info" /></div>
        <div class="col"><x-admin::stat-card label="Processing" :value="$processingCount" change="Being followed up" icon="ri-time-line" tone="warning" /></div>
        <div class="col"><x-admin::stat-card label="Confirmed" :value="$confirmedCount" change="Ready for travel" icon="ri-checkbox-circle-line" tone="success" /></div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">Booking requests</h4>
                <p class="text-muted mb-0">{{ $bookings->total() }} records{{ $selectedStatus ? ' · '.$selectedStatus->label() : '' }}</p>
            </div>
            @if ($selectedStatus)
                <a class="btn btn-soft-secondary btn-sm" href="{{ route('admin.bookings.index') }}">Clear status filter</a>
            @endif
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-2 mb-3">
                <div class="col-md-5 col-lg-4">
                    <label class="visually-hidden" for="booking-search">Search bookings</label>
                    <input type="search" class="form-control" id="booking-search" name="search" value="{{ $search }}" placeholder="Reference, traveler, email, package…">
                </div>
                <div class="col-md-4 col-lg-3">
                    <label class="visually-hidden" for="booking-status-filter">Filter by status</label>
                    <select class="form-select" id="booking-status-filter" name="status">
                        <option value="">All statuses</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" @selected($selectedStatus === $status)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto"><button class="btn btn-primary" type="submit"><i class="ri-search-line me-1"></i>Filter</button></div>
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Booking</th>
                            <th scope="col">Traveler</th>
                            <th scope="col">Package</th>
                            <th scope="col">Travel date</th>
                            <th scope="col">Guests</th>
                            <th scope="col">Quote</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td><a class="fw-semibold" href="{{ route('admin.bookings.show', $booking) }}">{{ $booking->reference ?: '#'.$booking->id }}</a><small class="d-block text-muted">{{ $booking->created_at->format('M j, Y') }}</small></td>
                                <td><span class="fw-medium">{{ $booking->customer_name }}</span><a class="d-block small" href="mailto:{{ $booking->email }}">{{ $booking->email }}</a></td>
                                <td>{{ $booking->package?->name ?? 'Package removed' }}</td>
                                <td>{{ $booking->travel_date->format('M j, Y') }}</td>
                                <td>{{ $booking->guests }}</td>
                                <td>{{ $booking->total_amount !== null ? $booking->currency.' '.number_format((float) $booking->total_amount, 2) : 'To confirm' }}</td>
                                <td><span class="badge bg-{{ $statusClasses[$booking->status->value] }}-subtle text-{{ $statusClasses[$booking->status->value] }}">{{ $booking->status->label() }}</span></td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-soft-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Actions for booking {{ $booking->reference }}"><i class="ri-more-fill align-bottom"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('admin.bookings.show', $booking) }}"><i class="ri-eye-line me-2 align-bottom text-muted"></i>View details</a></li>
                                            @foreach ($booking->status->nextStatuses() as $nextStatus)
                                                <li>
                                                    <form method="POST" action="{{ route('admin.bookings.update-status', $booking) }}" data-booking-status-confirm data-booking-reference="{{ $booking->reference ?: '#'.$booking->id }}" data-next-status="{{ $nextStatus->label() }}" data-dangerous="{{ $nextStatus->value === 'canceled' ? 'true' : 'false' }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="{{ $nextStatus->value }}">
                                                        <button class="dropdown-item {{ $nextStatus === \App\Enums\PackageBookingStatus::Canceled ? 'text-danger' : '' }}" type="submit">{{ $nextStatus === \App\Enums\PackageBookingStatus::Processing ? 'Start processing' : $nextStatus->label() }}</button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center py-5 text-muted">No bookings match these filters.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">{{ $bookings->links() }}</div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('admin/js/bookings.init.js') }}"></script>
    @endpush
</x-admin-layouts::app>
