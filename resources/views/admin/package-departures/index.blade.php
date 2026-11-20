<x-admin-layouts::app :title="$package ? $package->name.' departures' : __('Package departures')">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between gap-3">
        <div>
            <h4 class="mb-sm-0">{{ $package ? $package->name.' departures' : 'Package departures' }}</h4>
            <p class="text-muted mb-0 mt-1">{{ $package ? 'Review and manage scheduled dates for this package.' : 'Review upcoming dates, update availability, and add schedules for your packages.' }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            @if ($package)
                <a href="{{ route('admin.package-departures.index') }}" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i>All departures</a>
                <a href="{{ route('admin.packages.show', $package) }}" class="btn btn-light"><i class="ri-map-2-line me-1"></i>Package details</a>
            @else
                <a href="{{ route('admin.packages.index') }}" class="btn btn-light"><i class="ri-map-2-line me-1"></i>View packages</a>
            @endif
            <a href="{{ route('admin.package-departures.create', $package ? ['package_id' => $package->id] : []) }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Add departures</a>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-3 g-3 mb-3">
        <div class="col"><x-admin::stat-card label="Total departures" :value="$departureCount" change="All scheduled dates" icon="ri-calendar-event-line" tone="primary" /></div>
        <div class="col"><x-admin::stat-card label="Upcoming" :value="$upcomingCount" change="Starting today or later" icon="ri-calendar-check-line" tone="success" /></div>
        <div class="col"><x-admin::stat-card label="Needs confirmation" :value="$availableCount" change="Available to discuss" icon="ri-question-line" tone="warning" /></div>
    </div>

    <div class="card">
        <div class="card-header border-bottom-0 pb-0">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                <div>
                    <h4 class="card-title mb-1">Departure schedule</h4>
                    <p class="text-muted mb-0">{{ $package ? 'Only departures for '.$package->name.' are shown.' : 'Upcoming dates are shown first. Past dates remain available in the Past view.' }}</p>
                </div>
                <span class="badge bg-primary-subtle text-primary">{{ $departures->total() }} matching {{ \Illuminate\Support\Str::plural('departure', $departures->total()) }}</span>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist" aria-label="Departure date range">
                @foreach (['upcoming' => ['Upcoming', $upcomingCount], 'past' => ['Past', $pastCount], 'all' => ['All', $departureCount]] as $periodKey => [$periodLabel, $periodCount])
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $period === $periodKey ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['period' => $periodKey, 'page' => null]) }}" @if ($period === $periodKey) aria-current="page" @endif>
                            {{ $periodLabel }} <span class="badge bg-light text-muted ms-1">{{ $periodCount }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <form method="GET" action="{{ $package ? route('admin.package-departures.package', $package) : route('admin.package-departures.index') }}" class="rounded border bg-light-subtle p-3 mb-3">
                <input type="hidden" name="period" value="{{ $period }}">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-5 col-md-6">
                        <label for="departure-search" class="form-label small fw-medium">Search</label>
                        <div class="search-box">
                            <input id="departure-search" type="search" name="search" value="{{ $search }}" class="form-control search" placeholder="Package name or status">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <label for="departure-season" class="form-label small fw-medium">Season</label>
                        <select id="departure-season" name="season" class="form-select">
                            <option value="">All seasons</option>
                            @foreach (\App\Enums\Season::cases() as $seasonOption)
                                <option value="{{ $seasonOption->value }}" @selected($season === $seasonOption->value)>{{ $seasonOption->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6">
                        <label for="departure-status" class="form-label small fw-medium">Availability</label>
                        <select id="departure-status" name="status" class="form-select">
                            <option value="">All statuses</option>
                            @foreach ($statuses as $statusOption)
                                <option value="{{ $statusOption }}" @selected($status === $statusOption)>{{ str($statusOption)->replace('_', ' ')->headline() }}</option>
                            @endforeach
                            @if ($status !== '' && !$statuses->contains($status))
                                <option value="{{ $status }}" selected>{{ str($status)->replace('_', ' ')->headline() }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-2 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1" type="submit"><i class="ri-equalizer-line me-1"></i>Filter</button>
                        @if ($search !== '' || $season !== '' || $status !== '')
                            <a class="btn btn-light" href="{{ route('admin.package-departures.index', ['period' => $period]) }}" aria-label="Clear filters" title="Clear filters"><i class="ri-close-line"></i></a>
                        @endif
                    </div>
                </div>
            </form>

            @if ($departures->isNotEmpty())
                <div class="table-responsive table-card">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th scope="col">Package</th>
                                <th scope="col">Season</th>
                                <th scope="col">Travel dates</th>
                                <th scope="col">Price</th>
                                <th scope="col">Availability</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departures as $departure)
                                @php
                                    $statusTone = match ($departure->status) {
                                        'available_to_discuss', 'available' => 'success',
                                        'sold_out', 'unavailable' => 'danger',
                                        default => 'info',
                                    };
                                    $daysUntil = today()->diffInDays($departure->starts_on, false);
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.packages.show', $departure->package) }}" class="fw-semibold text-body">{{ $departure->package->name }}</a>
                                        @if (!$package)
                                            <div><a class="small text-muted" href="{{ route('admin.package-departures.package', $departure->package) }}">View this package’s departures</a></div>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-primary-subtle text-primary">{{ $departure->season->label() }}</span></td>
                                    <td>
                                        <div class="fw-medium">{{ $departure->starts_on->format('M j, Y') }}</div>
                                        @if ($departure->ends_on)
                                            <div class="small text-muted">Through {{ $departure->ends_on->format('M j, Y') }}</div>
                                        @endif
                                        @if ($daysUntil >= 0)
                                            <div class="small text-success mt-1">{{ $daysUntil === 0 ? 'Starts today' : 'Starts in '.$daysUntil.' '.\Illuminate\Support\Str::plural('day', $daysUntil) }}</div>
                                        @else
                                            <div class="small text-muted mt-1">Past departure</div>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">{{ $departure->price !== null ? $departure->currency.' '.number_format((float) $departure->price, 2) : 'Contact for price' }}</td>
                                    <td><span class="badge bg-{{ $statusTone }}-subtle text-{{ $statusTone }}">{{ str($departure->status)->replace('_', ' ')->headline() }}</span></td>
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">
                                            <a class="btn btn-soft-secondary btn-sm" href="{{ route('admin.package-departures.edit', $departure) }}" aria-label="Edit {{ $departure->package->name }} departure" title="Edit departure"><i class="ri-pencil-line"></i></a>
                                            <form action="{{ route('admin.package-departures.destroy', $departure) }}" method="POST" class="js-departure-delete-form" data-departure-label="{{ $departure->package->name }} — {{ $departure->starts_on->format('M j, Y') }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-soft-danger btn-sm" aria-label="Delete {{ $departure->package->name }} departure" title="Delete departure"><i class="ri-delete-bin-line"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
                    <p class="text-muted small mb-0">Showing {{ $departures->firstItem() }}–{{ $departures->lastItem() }} of {{ $departures->total() }} departures</p>
                    {{ $departures->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="avatar-md mx-auto mb-3"><div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-2"><i class="ri-calendar-event-line"></i></div></div>
                    @if ($search !== '' || $season !== '' || $status !== '')
                        <h5>No departures match these filters</h5>
                        <p class="text-muted mb-3">Try clearing a filter or search for a different package.</p>
                        <a href="{{ route('admin.package-departures.index', ['period' => $period]) }}" class="btn btn-light">Clear filters</a>
                    @elseif ($period === 'upcoming' && $package)
                        <h5>No upcoming dates for this package</h5>
                        <p class="text-muted mb-3">Add the next scheduled departure for {{ $package->name }}.</p>
                        <a href="{{ route('admin.package-departures.create', ['package_id' => $package->id]) }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Add departures</a>
                    @elseif ($period === 'upcoming')
                        <h5>No upcoming departures</h5>
                        <p class="text-muted mb-3">Add scheduled dates to help travelers find their next trip.</p>
                        <a href="{{ route('admin.package-departures.create') }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Add departures</a>
                    @elseif ($period === 'past')
                        <h5>No past departures</h5>
                        <p class="text-muted mb-0">Past travel dates will appear here for reference.</p>
                    @else
                        <h5>{{ $package ? 'No departures for this package yet' : 'No departures yet' }}</h5>
                        <p class="text-muted mb-3">{{ $package ? 'Create the first schedule for '.$package->name.'.' : 'Create the first schedule for a package.' }}</p>
                        <a href="{{ route('admin.package-departures.create', $package ? ['package_id' => $package->id] : []) }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Add departures</a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            jQuery(function ($) {
                $('.js-departure-delete-form').on('submit', function (event) {
                    const form = this;
                    if (form.dataset.confirmed === 'true') return;

                    if (!window.Swal) {
                        if (!window.confirm(`Delete departure ${form.dataset.departureLabel}?`)) event.preventDefault();
                        return;
                    }

                    event.preventDefault();
                    window.Swal.fire({
                        title: 'Delete departure?',
                        text: `Delete the ${form.dataset.departureLabel} departure?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Delete departure',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        confirmButtonColor: '#f06548',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.dataset.confirmed = 'true';
                            form.requestSubmit();
                        }
                    });
                });
            });
        </script>
    @endpush
</x-admin-layouts::app>
