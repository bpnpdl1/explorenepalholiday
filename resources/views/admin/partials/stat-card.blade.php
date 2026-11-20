@props(['label', 'value', 'change', 'icon', 'tone' => 'primary', 'valueId' => null, 'period' => 'This month', 'showTrend' => true])

<div class="card card-animate h-100">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1 overflow-hidden">
                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ $label }}</p>
            </div>
            <div class="flex-shrink-0">
                <span class="text-{{ $tone }} fs-14">@if ($showTrend)<i class="ri-arrow-up-line fs-13 align-middle"></i>@endif {{ $change }}</span>
            </div>
        </div>
        <div class="d-flex align-items-end justify-content-between mt-4">
            <div>
                <h4 @if ($valueId) id="{{ $valueId }}" @endif class="fs-22 fw-semibold ff-secondary mb-4">{{ $value }}</h4>
                <span class="badge bg-{{ $tone }}-subtle text-{{ $tone }} mb-0">{{ $period }}</span>
            </div>
            <div class="avatar-sm flex-shrink-0">
                <span class="avatar-title bg-{{ $tone }}-subtle rounded fs-3"><i class="{{ $icon }} text-{{ $tone }}"></i></span>
            </div>
        </div>
    </div>
</div>
