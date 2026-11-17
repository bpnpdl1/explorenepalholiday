<x-admin-layouts::app :title="$package['name']">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Package details</h4>
                    <p class="text-muted mb-0 mt-1">Review the package information and performance.</p>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.packages.index') }}">Packages</a></li>
                        <li class="breadcrumb-item active">{{ $package['name'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap align-items-start gap-3">
                        <div class="avatar-lg flex-shrink-0">
                            <span class="avatar-title rounded bg-primary-subtle text-primary fs-1"><i class="ri-landscape-line"></i></span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <span class="badge bg-{{ $package['status_class'] }}-subtle text-{{ $package['status_class'] }}">{{ $package['status'] }}</span>
                                <span class="badge bg-light text-body">{{ $package['category'] }}</span>
                            </div>
                            <h3 class="mb-2">{{ $package['name'] }}</h3>
                            <p class="text-muted mb-3">{{ $package['description'] }}</p>
                            <div class="d-flex flex-wrap gap-3 text-muted">
                                <span><i class="ri-map-pin-line text-primary me-1"></i>{{ $package['destination'] }}</span>
                                <span><i class="ri-time-line text-primary me-1"></i>{{ $package['duration'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Package overview</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0">{{ $package['description'] }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h5 class="card-title mb-0 flex-grow-1">Travel details</h5>
                    <i class="ri-route-line text-primary fs-18"></i>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <p class="text-muted mb-1">Destination</p>
                            <h6 class="mb-0">{{ $package['destination'] }}</h6>
                        </div>
                        <div class="col-sm-6">
                            <p class="text-muted mb-1">Package category</p>
                            <h6 class="mb-0">{{ $package['category'] }}</h6>
                        </div>
                        <div class="col-sm-6">
                            <p class="text-muted mb-1">Duration</p>
                            <h6 class="mb-0">{{ $package['duration'] }}</h6>
                        </div>
                        <div class="col-sm-6">
                            <p class="text-muted mb-1">Starting price</p>
                            <h6 class="mb-0">{{ $package['price'] }} <span class="text-muted fw-normal">per person</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Package status</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-muted">Visibility</span>
                        <span class="badge bg-{{ $package['status_class'] }}-subtle text-{{ $package['status_class'] }}">{{ $package['status'] }}</span>
                    </div>
                    <div class="alert alert-{{ $package['status_class'] === 'success' ? 'success' : 'warning' }} border-0 mb-0" role="note">
                        <i class="ri-information-line me-1 align-middle"></i>
                        {{ $package['status'] === 'Published' ? 'This package is published in the sample catalog.' : 'This package is a draft and is not visible in the sample catalog.' }}
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Package performance</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm bg-primary-subtle rounded me-3 d-flex align-items-center justify-content-center text-primary">
                            <i class="ri-calendar-check-line fs-20"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Bookings</p>
                            <h4 class="mb-0">{{ $package['bookings'] }}</h4>
                        </div>
                    </div>
                    <p class="text-muted mb-0">Booking totals are sample figures for this preview.</p>
                </div>
            </div>

            <a href="{{ route('admin.packages.index') }}" class="btn btn-light w-100">
                <i class="ri-arrow-left-line me-1 align-bottom"></i>Back to packages
            </a>
        </div>
    </div>
</x-admin-layouts::app>
