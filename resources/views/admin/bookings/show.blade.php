<x-admin-layouts::app :title="'Booking '.($booking->reference ?: '#'.$booking->id)">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between gap-3">
        <div>
            <h4 class="mb-sm-0">Booking {{ $booking->reference ?: '#'.$booking->id }}</h4>
            <p class="text-muted mb-0 mt-1">Received {{ $booking->created_at->format('M j, Y \\a\\t g:i A') }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            @if ($booking->package)
                <a href="{{ route('admin.packages.show', $booking->package) }}" class="btn btn-soft-primary"><i class="ri-map-2-line me-1"></i>Package details</a>
            @endif
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i>Back to bookings</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div><h5 class="card-title mb-1">Traveler details</h5><p class="text-muted mb-0">Contact the traveler to confirm availability and arrangements.</p></div>
                    <span class="badge bg-{{ $statusClasses[$booking->status->value] }}-subtle text-{{ $statusClasses[$booking->status->value] }}">{{ $booking->status->label() }}</span>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Name</dt><dd class="col-sm-9">{{ $booking->customer_name }}</dd>
                        <dt class="col-sm-3">Email</dt><dd class="col-sm-9"><a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a></dd>
                        <dt class="col-sm-3">Phone / WhatsApp</dt><dd class="col-sm-9"><a href="tel:{{ $booking->phone }}">{{ $booking->phone }}</a></dd>
                        <dt class="col-sm-3">Country</dt><dd class="col-sm-9">{{ $booking->country_of_residence ?: 'Not provided' }}</dd>
                    </dl>
                    @php
                        $whatsappPhone = preg_replace('/\D+/', '', $booking->phone);
                        $whatsappMessage = rawurlencode('Hello '.$booking->customer_name.', we received your booking request '.($booking->reference ?: '#'.$booking->id).' for '.($booking->package?->name ?? 'your trip').'.');
                    @endphp
                    @if ($whatsappPhone)
                        <a class="btn btn-success mt-2" href="https://wa.me/{{ $whatsappPhone }}?text={{ $whatsappMessage }}" target="_blank" rel="noopener noreferrer"><i class="ri-whatsapp-line me-1" aria-hidden="true"></i>Message on WhatsApp</a>
                    @endif
                    <hr>
                    <h6>Special requests</h6>
                    <p class="mb-0" style="white-space: pre-line">{{ $booking->special_requests ?: 'No additional requests provided.' }}</p>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Trip details</h5></div>
                <div class="card-body">
                    <p class="text-muted small mb-1">Package</p>
                    @if ($booking->package)
                        <a class="fw-semibold" href="{{ route('admin.packages.show', $booking->package) }}">{{ $booking->package->name }}</a>
                        @if ($booking->package->is_published)
                            <a class="small d-block mt-1" href="{{ route('packages.show', $booking->package) }}" target="_blank" rel="noopener noreferrer">View on website <i class="ri-external-link-line"></i></a>
                        @endif
                    @else
                        <p>Package removed</p>
                    @endif
                    <hr>
                    <p class="text-muted small mb-1">Preferred travel date</p><p class="fw-medium">{{ $booking->travel_date->format('M j, Y') }}</p>
                    @if ($booking->departure)
                        <p class="text-muted small mb-1">Scheduled departure</p>
                        <p class="fw-medium">{{ $booking->departure->starts_on->format('M j, Y') }}@if ($booking->departure->ends_on) – {{ $booking->departure->ends_on->format('M j, Y') }}@endif ({{ $booking->departure->season->label() }})</p>
                    @endif
                    <p class="text-muted small mb-1">Group size</p><p class="fw-medium">{{ $booking->guests }} {{ \Illuminate\Support\Str::plural('traveler', $booking->guests) }}</p>
                    <p class="text-muted small mb-1">Quote</p><p class="fw-medium mb-0">{{ $booking->total_amount !== null ? $booking->currency.' '.number_format((float) $booking->total_amount, 2) : 'To confirm with traveler' }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Update booking status</h5></div>
                <div class="card-body">
                    @error('status')<div class="alert alert-danger py-2">{{ $message }}</div>@enderror
                    @forelse ($booking->status->nextStatuses() as $nextStatus)
                        <form class="mb-2" method="POST" action="{{ route('admin.bookings.update-status', $booking) }}" data-booking-status-confirm data-booking-reference="{{ $booking->reference ?: '#'.$booking->id }}" data-next-status="{{ $nextStatus->label() }}" data-dangerous="{{ $nextStatus->value === 'canceled' ? 'true' : 'false' }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="{{ $nextStatus->value }}">
                            <button class="btn {{ $nextStatus === \App\Enums\PackageBookingStatus::Canceled ? 'btn-soft-danger' : 'btn-primary' }} w-100" type="submit">
                                <i class="{{ $nextStatus === \App\Enums\PackageBookingStatus::Canceled ? 'ri-close-circle-line' : 'ri-arrow-right-line' }} me-1"></i>
                                {{ $nextStatus === \App\Enums\PackageBookingStatus::Processing ? 'Start processing' : 'Mark as '.$nextStatus->label() }}
                            </button>
                        </form>
                    @empty
                        <p class="text-muted mb-0">This booking is canceled and has no further status changes.</p>
                    @endforelse
                    <small class="text-muted d-block mt-3">Status changes are saved to the booking record.</small>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('admin/js/bookings.init.js') }}"></script>
    @endpush
</x-admin-layouts::app>
