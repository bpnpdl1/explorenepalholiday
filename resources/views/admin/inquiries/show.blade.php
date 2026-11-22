<x-admin-layouts::app :title="'Inquiry #'.$inquiry->id">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between gap-3">
        <div>
            <h4 class="mb-sm-0">Inquiry #{{ $inquiry->id }}</h4>
            <p class="text-muted mb-0 mt-1">Submitted {{ $inquiry->created_at->format('M j, Y \\a\\t g:i A') }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            @if ($inquiry->package)
                <a href="{{ route('admin.packages.show', $inquiry->package) }}" class="btn btn-soft-primary">
                    <i class="ri-map-2-line me-1"></i>Package details
                </a>
            @endif
            <a href="{{ route('admin.inquiries.index') }}" class="btn btn-light">
                <i class="ri-arrow-left-line me-1"></i>Back to inquiries
            </a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h5 class="card-title mb-1">Traveler details</h5>
                        <p class="text-muted mb-0">Contact the traveler to follow up on this trip request.</p>
                    </div>
                    <span class="badge bg-{{ $statusClasses[$inquiry->status->value] }}-subtle text-{{ $statusClasses[$inquiry->status->value] }}">
                        {{ $inquiry->status->label() }}
                    </span>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Name</dt>
                        <dd class="col-sm-9">{{ $inquiry->customer_name }}</dd>
                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9"><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></dd>
                        <dt class="col-sm-3">Phone / WhatsApp</dt>
                        <dd class="col-sm-9"><a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a></dd>
                    </dl>
                    @php
                        $whatsappPhone = preg_replace('/\D+/', '', $inquiry->phone);
                        $whatsappMessage = rawurlencode(
                            'Hello '.$inquiry->customer_name.', thanks for your inquiry about '.($inquiry->package?->name ?? 'your trip').'. We would like to help with your travel plans.',
                        );
                    @endphp
                    @if ($whatsappPhone)
                        <a class="btn btn-success mt-2" href="https://wa.me/{{ $whatsappPhone }}?text={{ $whatsappMessage }}"
                            target="_blank" rel="noopener noreferrer">
                            <i class="ri-whatsapp-line me-1" aria-hidden="true"></i>Message on WhatsApp
                        </a>
                    @endif

                    <hr>
                    <h6>Traveler's message</h6>
                    <p class="mb-0" style="white-space: pre-line">{{ $inquiry->message ?: 'No additional message provided.' }}</p>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Trip request</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-1">Interested package</p>
                    @if ($inquiry->package)
                        <a class="fw-semibold" href="{{ route('admin.packages.show', $inquiry->package) }}">{{ $inquiry->package->name }}</a>
                        @if ($inquiry->package->is_published)
                            <a class="small d-block mt-1" href="{{ route('packages.show', $inquiry->package) }}" target="_blank" rel="noopener noreferrer">View on website <i class="ri-external-link-line"></i></a>
                        @endif
                    @else
                        <p class="mb-0">Package removed</p>
                    @endif

                    <hr>
                    <p class="text-muted small mb-1">Preferred travel window</p>
                    <p class="fw-medium">{{ $inquiry->travelWindowLabel() }}</p>

                    <p class="text-muted small mb-1">Received</p>
                    <p class="fw-medium mb-0">{{ $inquiry->created_at->format('M j, Y g:i A') }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Update inquiry status</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.inquiries.update-status', $inquiry) }}">
                        @csrf
                        @method('PATCH')
                        <label for="inquiry-status" class="form-label">Status</label>
                        <select class="form-select mb-3" id="inquiry-status" name="status" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->value }}" @selected($status === $inquiry->status)>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary w-100" type="submit">
                            <i class="ri-save-line me-1"></i>Save status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layouts::app>
