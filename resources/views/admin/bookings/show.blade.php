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
                    @error('note')<div class="alert alert-danger py-2">{{ $message }}</div>@enderror
                    @if ($booking->status->nextStatuses())
                        <form method="POST" action="{{ route('admin.bookings.update-status', $booking) }}" data-booking-status-confirm data-booking-reference="{{ $booking->reference ?: '#'.$booking->id }}">
                            @csrf
                            @method('PATCH')
                            <label class="form-label" for="booking-next-status">Move to</label>
                            <select class="form-select mb-3" id="booking-next-status" name="status" required>
                                @foreach ($booking->status->nextStatuses() as $nextStatus)
                                    <option value="{{ $nextStatus->value }}">{{ $nextStatus->label() }}</option>
                                @endforeach
                            </select>
                            <label class="form-label" for="booking-status-note">Internal note <span class="text-muted">(optional)</span></label>
                            <textarea class="form-control mb-3" id="booking-status-note" name="note" rows="3" maxlength="1000" placeholder="Add context for this status change">{{ old('note') }}</textarea>
                            <button class="btn btn-primary w-100" type="submit"><i class="ri-save-line me-1"></i>Update status</button>
                        </form>
                    @else
                        <p class="text-muted mb-0">This booking is canceled and has no further status changes.</p>
                    @endif
                    <small class="text-muted d-block mt-3">Status changes are saved to the booking record.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div><h5 class="card-title mb-1">Booking activity</h5><p class="text-muted mb-0">Status changes and request history.</p></div>
            <span class="badge bg-light text-body">{{ $booking->logs->count() }} {{ \Illuminate\Support\Str::plural('event', $booking->logs->count()) }}</span>
        </div>
        <div class="card-body">
            @forelse ($booking->logs as $log)
                <div class="d-flex gap-3 {{ ! $loop->last ? 'pb-3 mb-3 border-bottom' : '' }}">
                    <span class="avatar-title rounded-circle bg-{{ $statusClasses[$log->to_status->value] }}-subtle text-{{ $statusClasses[$log->to_status->value] }} flex-shrink-0" style="width: 2.25rem; height: 2.25rem;">
                        <i class="{{ $log->from_status ? 'ri-arrow-right-line' : 'ri-add-line' }}"></i>
                    </span>
                    <div class="flex-grow-1">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <strong>
                                @switch($log->event)
                                    @case(\App\Enums\PackageBookingLogEvent::Submitted)
                                        Booking request received · {{ $log->to_status->label() }}
                                        @break
                                    @case(\App\Enums\PackageBookingLogEvent::StatusChanged)
                                        {{ $log->from_status->label() }} <i class="ri-arrow-right-line mx-1 text-muted"></i> {{ $log->to_status->label() }}
                                        @break
                                    @case(\App\Enums\PackageBookingLogEvent::HistoryInitialized)
                                        Initial status recorded · {{ $log->to_status->label() }}
                                        @break
                                @endswitch
                            </strong>
                            <time class="text-muted small" datetime="{{ $log->created_at->toIso8601String() }}">{{ $log->created_at->format('M j, Y g:i A') }}</time>
                        </div>
                        <p class="text-muted small mb-0">
                            @switch($log->event)
                                @case(\App\Enums\PackageBookingLogEvent::Submitted) Traveler / website @break
                                @case(\App\Enums\PackageBookingLogEvent::StatusChanged) {{ $log->user?->name ?? 'Administrator' }} @break
                                @case(\App\Enums\PackageBookingLogEvent::HistoryInitialized) System @break
                            @endswitch
                        </p>
                        @if ($log->note)<p class="mt-2 mb-0" style="white-space: pre-line">{{ $log->note }}</p>@endif
                    </div>
                </div>
            @empty
                <p class="text-muted mb-0">No activity has been recorded for this booking.</p>
            @endforelse
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('admin/js/bookings.init.js') }}"></script>
    @endpush
</x-admin-layouts::app>
