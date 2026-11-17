<x-admin-layouts::app :title="__('Dashboard')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Admin dashboard</h4>
                    <p class="text-muted mb-0 mt-1">A quick look at your Explore Nepal Holidays site.</p>
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
        <div class="col">
            <x-admin::stat-card label="Bookings" value="1,284" change="12.8%" icon="ri-calendar-check-line" tone="primary" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Inquiries" value="326" change="8.4%" icon="ri-question-answer-line" tone="success" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Published packages" value="24" change="3 new" icon="ri-map-2-line" tone="warning" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Website visitors" value="18,492" change="16.2%" icon="ri-user-3-line" tone="info" />
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-xl-8">
            <div class="card card-height-100">
                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Bookings &amp; inquiries</h4>
                    <span class="badge bg-light text-muted">Example overview</span>
                </div>
                <div class="card-body pt-0">
                    <div id="admin-bookings-chart" aria-label="Bookings and inquiries chart"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Booking status</h4>
                    <span class="text-muted fs-13">This month</span>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-grow-1"><p class="text-muted mb-1">Confirmed</p><h5 class="mb-0">186</h5></div>
                        <div class="flex-shrink-0 text-end">
                            <span class="text-success fw-medium">68%</span>
                            <div class="progress mt-2" style="width: 130px; height: 6px;"><div class="progress-bar bg-success" role="progressbar" style="width: 68%" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100"></div></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-grow-1"><p class="text-muted mb-1">Awaiting payment</p><h5 class="mb-0">54</h5></div>
                        <div class="flex-shrink-0 text-end">
                            <span class="text-warning fw-medium">20%</span>
                            <div class="progress mt-2" style="width: 130px; height: 6px;"><div class="progress-bar bg-warning" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1"><p class="text-muted mb-1">New inquiries</p><h5 class="mb-0">33</h5></div>
                        <div class="flex-shrink-0 text-end">
                            <span class="text-primary fw-medium">12%</span>
                            <div class="progress mt-2" style="width: 130px; height: 6px;"><div class="progress-bar bg-primary" role="progressbar" style="width: 12%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100"></div></div>
                        </div>
                    </div>
                    <div class="alert alert-info border-0 mt-4 mb-0" role="note">
                        <i class="ri-information-line me-1 align-middle"></i>
                        Dashboard figures are sample data until booking records are connected.
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
                    <span class="badge bg-primary-subtle text-primary">Latest activity</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light text-muted">
                                <tr><th scope="col">Booking</th><th scope="col">Package</th><th scope="col">Travel date</th><th scope="col">Guests</th><th scope="col">Status</th></tr>
                            </thead>
                            <tbody>
                                <tr><td><span class="fw-medium">#ENH-2481</span></td><td>Everest Base Camp Trek</td><td>24 Oct, 2026</td><td>2</td><td><span class="badge bg-success-subtle text-success">Confirmed</span></td></tr>
                                <tr><td><span class="fw-medium">#ENH-2480</span></td><td>Annapurna Circuit</td><td>02 Nov, 2026</td><td>4</td><td><span class="badge bg-warning-subtle text-warning">Awaiting payment</span></td></tr>
                                <tr><td><span class="fw-medium">#ENH-2479</span></td><td>Chitwan Wildlife Safari</td><td>12 Nov, 2026</td><td>2</td><td><span class="badge bg-success-subtle text-success">Confirmed</span></td></tr>
                                <tr><td><span class="fw-medium">#ENH-2478</span></td><td>Kathmandu Valley Tour</td><td>18 Nov, 2026</td><td>3</td><td><span class="badge bg-info-subtle text-info">New inquiry</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Popular packages</h4>
                    <i class="ri-fire-line text-warning fs-18"></i>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-sm bg-primary-subtle rounded me-3 d-flex align-items-center justify-content-center text-primary"><i class="ri-landscape-line fs-20"></i></div>
                        <div class="flex-grow-1"><h6 class="mb-1">Everest Base Camp</h6><p class="text-muted mb-0">Trekking · 14 days</p></div>
                        <span class="fw-medium">84 bookings</span>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-sm bg-success-subtle rounded me-3 d-flex align-items-center justify-content-center text-success"><i class="ri-route-line fs-20"></i></div>
                        <div class="flex-grow-1"><h6 class="mb-1">Annapurna Circuit</h6><p class="text-muted mb-0">Trekking · 12 days</p></div>
                        <span class="fw-medium">67 bookings</span>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-sm bg-warning-subtle rounded me-3 d-flex align-items-center justify-content-center text-warning"><i class="ri-compass-3-line fs-20"></i></div>
                        <div class="flex-grow-1"><h6 class="mb-1">Kathmandu Valley</h6><p class="text-muted mb-0">Culture · 5 days</p></div>
                        <span class="fw-medium">52 bookings</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-info-subtle rounded me-3 d-flex align-items-center justify-content-center text-info"><i class="ri-sun-line fs-20"></i></div>
                        <div class="flex-grow-1"><h6 class="mb-1">Chitwan Safari</h6><p class="text-muted mb-0">Wildlife · 3 days</p></div>
                        <span class="fw-medium">39 bookings</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('admin/velzon/libs/apexcharts/apexcharts.min.js') }}"></script>
    @endpush
</x-admin-layouts::app>
