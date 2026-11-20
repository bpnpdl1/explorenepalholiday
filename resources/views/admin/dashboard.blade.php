<x-admin-layouts::app :title="__('Dashboard')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Admin dashboard</h4>
                    <p class="text-muted mb-0 mt-1">Live activity and follow-up across Explore Nepal Holidays.</p>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3 mb-3">
        @foreach ($stats as $stat)
            <div class="col">
                <x-admin::stat-card
                    :label="$stat['label']"
                    :value="number_format($stat['value'])"
                    :change="$stat['change']"
                    :period="$stat['period']"
                    :icon="$stat['icon']"
                    :tone="$stat['tone']"
                    :show-trend="false"
                />
            </div>
        @endforeach
    </div>

    <div class="row g-3 mb-3">
        <div class="col-xl-8">
            <div class="card card-height-100">
                <div class="card-header border-0 align-items-center d-flex">
                    <div class="flex-grow-1">
                        <h4 class="card-title mb-1">Bookings and inquiries</h4>
                        <p class="text-muted mb-0">Monthly submissions over the last six months</p>
                    </div>
                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-soft-primary btn-sm">View inquiries</a>
                </div>
                <div class="card-body pt-0">
                    <div id="admin-bookings-chart" aria-label="Monthly bookings and inquiries chart"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Booking status</h4>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-soft-secondary btn-sm">All bookings</a>
                </div>
                <div class="card-body">
                    @forelse ($bookingStatuses as $status)
                        @php
                            $count = $bookingStatusCounts[$status->value] ?? 0;
                            $percentage = $bookingCount > 0 ? (int) round(($count / $bookingCount) * 100) : 0;
                            $tone = $bookingStatusClasses[$status->value];
                        @endphp
                        <div class="d-flex align-items-center {{ $loop->last ? '' : 'mb-4' }}">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1">{{ $status->label() }}</p>
                                <h5 class="mb-0">{{ number_format($count) }}</h5>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <span class="text-{{ $tone }} fw-medium">{{ $percentage }}%</span>
                                <div class="progress mt-2" style="width: 130px; height: 6px;">
                                    <div class="progress-bar bg-{{ $tone }}" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No booking statuses are available.</p>
                    @endforelse

                    <div class="border-top pt-3 mt-4 d-flex align-items-center justify-content-between">
                        <span class="text-muted">All inquiries</span>
                        <span class="fw-semibold">{{ number_format($inquiryCount) }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <span class="text-muted">Average guest rating</span>
                        <span class="fw-semibold">
                            @if ($averageReviewRating !== null)
                                <i class="ri-star-fill text-warning me-1"></i>{{ number_format((float) $averageReviewRating, 1) }} / 5
                            @else
                                <span class="text-muted">No reviews yet</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Recent bookings</h4>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-soft-primary btn-sm">View all</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">Booking</th>
                                    <th scope="col">Traveler</th>
                                    <th scope="col">Package</th>
                                    <th scope="col">Travel date</th>
                                    <th scope="col">Guests</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentBookings as $booking)
                                    @php($bookingTone = $bookingStatusClasses[$booking->status->value])
                                    <tr>
                                        <td>
                                            <a class="fw-semibold" href="{{ route('admin.bookings.show', $booking) }}">{{ $booking->reference ?: '#'.$booking->id }}</a>
                                            <small class="d-block text-muted">{{ $booking->created_at->format('M j, Y') }}</small>
                                        </td>
                                        <td><span class="fw-medium">{{ $booking->customer_name }}</span><small class="d-block text-muted">{{ $booking->email }}</small></td>
                                        <td>{{ $booking->package?->name ?? 'Package removed' }}</td>
                                        <td>{{ $booking->travel_date?->format('M j, Y') ?? 'Not set' }}</td>
                                        <td>{{ $booking->guests }}</td>
                                        <td><span class="badge bg-{{ $bookingTone }}-subtle text-{{ $bookingTone }}">{{ $booking->status->label() }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center py-5 text-muted">No bookings have been submitted yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card mb-3">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Recent inquiries</h4>
                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-soft-primary btn-sm">View all</a>
                </div>
                <div class="card-body">
                    @forelse ($recentInquiries as $inquiry)
                        <div class="d-flex align-items-start {{ $loop->last ? '' : 'mb-3' }}">
                            <div class="avatar-xs flex-shrink-0 me-3">
                                <span class="avatar-title rounded-circle bg-{{ $inquiry['source'] === 'package' ? 'primary' : 'info' }}-subtle text-{{ $inquiry['source'] === 'package' ? 'primary' : 'info' }}">
                                    <i class="{{ $inquiry['source'] === 'package' ? 'ri-suitcase-line' : 'ri-global-line' }}"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 min-width-0">
                                <div class="d-flex align-items-center justify-content-between gap-2">
                                    <h6 class="mb-1 text-truncate">{{ $inquiry['name'] }}</h6>
                                    <small class="text-muted flex-shrink-0">{{ $inquiry['created_at']->diffForHumans() }}</small>
                                </div>
                                <p class="text-muted mb-1 text-truncate">{{ $inquiry['subject'] }}</p>
                                <div class="d-flex align-items-center justify-content-between gap-2">
                                    <span class="badge bg-{{ $inquiry['status_class'] }}-subtle text-{{ $inquiry['status_class'] }}">{{ $inquiry['status'] }}</span>
                                    <a class="small" href="{{ $inquiry['source'] === 'package' ? route('admin.inquiries.show', $inquiry['id']) : route('admin.site-inquiries.show', $inquiry['id']) }}">Open</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No inquiries have been submitted yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Most booked packages</h4>
                    <a href="{{ route('admin.packages.index') }}" class="btn btn-soft-secondary btn-sm">Packages</a>
                </div>
                <div class="card-body">
                    @forelse ($popularPackages as $package)
                        <a href="{{ route('admin.packages.show', $package) }}" class="d-flex align-items-center text-reset {{ $loop->last ? '' : 'mb-3' }}">
                            <div class="avatar-sm bg-primary-subtle rounded me-3 d-flex align-items-center justify-content-center text-primary flex-shrink-0">
                                <i class="ri-route-line fs-20"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-1 text-truncate">{{ $package->name }}</h6>
                                <p class="text-muted mb-0">{{ $package->duration_days ? $package->duration_days.' days' : 'Duration not set' }}</p>
                            </div>
                            <span class="fw-medium ms-2 flex-shrink-0">{{ number_format($package->bookings_count) }}</span>
                        </a>
                    @empty
                        <p class="text-muted mb-0">Package popularity will appear after the first booking.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('admin/velzon/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const chartElement = document.querySelector('#admin-bookings-chart');

                if (!chartElement || typeof ApexCharts === 'undefined') {
                    return;
                }

                new ApexCharts(chartElement, {
                    chart: { type: 'area', height: 300, toolbar: { show: false }, zoom: { enabled: false } },
                    series: [
                        { name: 'Bookings', data: @js($chart['bookings']) },
                        { name: 'Inquiries', data: @js($chart['inquiries']) },
                    ],
                    colors: ['#405189', '#0ab39c'],
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 2 },
                    fill: { type: 'gradient', gradient: { opacityFrom: 0.28, opacityTo: 0.04 } },
                    xaxis: { categories: @js($chart['labels']), axisBorder: { show: false }, axisTicks: { show: false } },
                    yaxis: { min: 0, forceNiceScale: true, labels: { formatter: value => Math.round(value) } },
                    grid: { borderColor: '#f1f1f1', strokeDashArray: 4 },
                    legend: { position: 'top', horizontalAlign: 'right' },
                    tooltip: { y: { formatter: value => `${value} submissions` } },
                    noData: { text: 'No activity for this period' },
                }).render();
            });
        </script>
    @endpush
</x-admin-layouts::app>
