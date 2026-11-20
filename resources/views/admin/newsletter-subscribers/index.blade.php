<x-admin-layouts::app :title="__('Newsletter subscribers')">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <div>
            <h4 class="mb-sm-0">Newsletter subscribers</h4>
            <p class="text-muted mb-0 mt-1">Manage people who agreed to receive occasional travel updates.</p>
        </div>
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
            <li class="breadcrumb-item active">Newsletter subscribers</li>
        </ol>
    </div>

    <div class="row row-cols-1 row-cols-sm-3 g-3 mb-3">
        <div class="col"><x-admin::stat-card label="Total subscribers" :value="$subscriberCount" change="All records" icon="ri-mail-send-line" tone="primary" /></div>
        <div class="col"><x-admin::stat-card label="Subscribed" :value="$subscribedCount" change="Receiving updates" icon="ri-mail-check-line" tone="success" /></div>
        <div class="col"><x-admin::stat-card label="Unsubscribed" :value="$unsubscribedCount" change="Not receiving updates" icon="ri-mail-close-line" tone="secondary" /></div>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div><h4 class="card-title mb-1">Subscriber list</h4><p class="text-muted mb-0">Only subscribed contacts should be included in newsletter sends.</p></div>
            <a class="btn btn-success" href="{{ route('admin.newsletter-subscribers.export', ['search' => $search, 'status' => $selectedStatus?->value]) }}"><i class="ri-file-excel-2-line me-1" aria-hidden="true"></i>Export Excel</a>
            <span class="badge bg-primary-subtle text-primary">{{ $subscribers->total() }}{{ $selectedStatus || $search !== '' ? ' filtered of '.$subscriberCount : '' }} records</span>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.newsletter-subscribers.index') }}" class="row g-2 mb-3">
                <div class="col-md-5"><input type="search" class="form-control" name="search" value="{{ $search }}" placeholder="Search email addresses" aria-label="Search subscribers"></div>
                <div class="col-md-3"><select class="form-select" name="status" aria-label="Filter by subscription status"><option value="">All statuses</option>@foreach ($statuses as $status)<option value="{{ $status->value }}" @selected($selectedStatus === $status)>{{ $status->label() }}</option>@endforeach</select></div>
                <div class="col-auto"><button class="btn btn-primary" type="submit">Filter</button></div>
                @if ($selectedStatus || $search !== '')<div class="col-auto"><a class="btn btn-light" href="{{ route('admin.newsletter-subscribers.index') }}">Clear</a></div>@endif
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light text-muted"><tr><th>Email address</th><th>Consent recorded</th><th>Last subscribed</th><th>Status</th><th class="text-end">Update status</th></tr></thead>
                    <tbody>
                        @forelse ($subscribers as $subscriber)
                            <tr>
                                <td><a href="mailto:{{ $subscriber->email }}">{{ $subscriber->email }}</a></td>
                                <td>{{ $subscriber->consented_at->format('M j, Y g:i A') }}</td>
                                <td>{{ $subscriber->subscribed_at?->format('M j, Y g:i A') ?? '—' }}</td>
                                <td><span class="badge bg-{{ $statusClasses[$subscriber->status->value] }}-subtle text-{{ $statusClasses[$subscriber->status->value] }}">{{ $subscriber->status->label() }}</span></td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.newsletter-subscribers.update-status', $subscriber) }}" class="d-inline-flex align-items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select class="form-select form-select-sm" name="status" aria-label="Status for {{ $subscriber->email }}">
                                            @foreach ($statuses as $status)<option value="{{ $status->value }}" @selected($subscriber->status === $status)>{{ $status->label() }}</option>@endforeach
                                        </select>
                                        <button class="btn btn-soft-primary btn-sm" type="submit">Save</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No newsletter subscribers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $subscribers->links() }}</div>
        </div>
    </div>
</x-admin-layouts::app>
