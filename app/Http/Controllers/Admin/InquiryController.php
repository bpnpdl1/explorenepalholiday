<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request): View
    {
        $stageFilters = [
            'new' => 'New',
            'in-progress' => 'In progress',
            'awaiting-traveler' => 'Awaiting traveler',
            'converted' => 'Converted to booking',
            'closed' => 'Closed',
        ];

        $selectedStage = $request->query('stage');
        $selectedStage = is_string($selectedStage) && array_key_exists($selectedStage, $stageFilters)
            ? $selectedStage
            : '';
        $selectedStatus = $stageFilters[$selectedStage] ?? null;

        $statusClasses = [
            'New' => 'info',
            'In progress' => 'primary',
            'Awaiting traveler' => 'warning',
            'Converted to booking' => 'success',
            'Closed' => 'secondary',
        ];

        $inquiries = [
            [
                'reference' => 'INQ-1042',
                'customer' => 'Riya Patel',
                'email' => 'riya.patel@example.com',
                'phone' => '+977 980-000-1042',
                'package' => 'Everest Base Camp Trek',
                'travel_period' => '22 Oct, 2026',
                'travelers' => 2,
                'received' => '15 Oct, 2026',
                'status' => 'New',
                'message' => 'Would like to know the best dates and what is included in the trek.',
            ],
            [
                'reference' => 'INQ-1041',
                'customer' => 'Daniel Kim',
                'email' => 'daniel.kim@example.com',
                'phone' => '+82 10-0000-1041',
                'package' => 'Annapurna Circuit',
                'travel_period' => '02 Nov, 2026',
                'travelers' => 4,
                'received' => '14 Oct, 2026',
                'status' => 'In progress',
                'message' => 'Asked about private transport from Kathmandu and accommodation upgrades.',
            ],
            [
                'reference' => 'INQ-1040',
                'customer' => 'Amelia Scott',
                'email' => 'amelia.scott@example.com',
                'phone' => '+44 7700 000040',
                'package' => 'Chitwan Wildlife Safari',
                'travel_period' => '12 Nov, 2026',
                'travelers' => 2,
                'received' => '13 Oct, 2026',
                'status' => 'Awaiting traveler',
                'message' => 'Itinerary and revised quote sent; waiting for the traveler to confirm.',
            ],
            [
                'reference' => 'INQ-1039',
                'customer' => 'Luis Garcia',
                'email' => 'luis.garcia@example.com',
                'phone' => '+34 600 000 039',
                'package' => 'Kathmandu Valley Tour',
                'travel_period' => '18 Nov, 2026',
                'travelers' => 3,
                'received' => '12 Oct, 2026',
                'status' => 'Converted to booking',
                'message' => 'Traveler confirmed the itinerary and completed a booking.',
            ],
            [
                'reference' => 'INQ-1038',
                'customer' => 'Mia Chen',
                'email' => 'mia.chen@example.com',
                'phone' => '+1 415-000-0038',
                'package' => 'Pokhara Adventure Escape',
                'travel_period' => '26 Nov, 2026',
                'travelers' => 2,
                'received' => '11 Oct, 2026',
                'status' => 'Closed',
                'message' => 'Traveler decided to postpone the trip until next season.',
            ],
            [
                'reference' => 'INQ-1037',
                'customer' => 'Oliver Brown',
                'email' => 'oliver.brown@example.com',
                'phone' => '+61 400 000 037',
                'package' => 'Manaslu Circuit Trek',
                'travel_period' => '05 Dec, 2026',
                'travelers' => 2,
                'received' => '10 Oct, 2026',
                'status' => 'New',
                'message' => 'Looking for a guided trek and information about required permits.',
            ],
            [
                'reference' => 'INQ-1036',
                'customer' => 'Sofia Rossi',
                'email' => 'sofia.rossi@example.com',
                'phone' => '+39 320 000 0036',
                'package' => 'Langtang Valley Trek',
                'travel_period' => '10 Dec, 2026',
                'travelers' => 1,
                'received' => '09 Oct, 2026',
                'status' => 'In progress',
                'message' => 'Discussing a solo traveler departure and guide availability.',
            ],
        ];

        $visibleInquiryCount = $selectedStatus
            ? count(array_filter($inquiries, fn (array $inquiry): bool => $inquiry['status'] === $selectedStatus))
            : count($inquiries);

        return view('admin.inquiries.index', [
            'inquiries' => $inquiries,
            'stageFilters' => $stageFilters,
            'statusClasses' => $statusClasses,
            'selectedStatus' => $selectedStatus,
            'inquiryCount' => count($inquiries),
            'newCount' => count(array_filter($inquiries, fn (array $inquiry): bool => $inquiry['status'] === 'New')),
            'activeCount' => count(array_filter($inquiries, fn (array $inquiry): bool => in_array($inquiry['status'], ['In progress', 'Awaiting traveler'], true))),
            'convertedCount' => count(array_filter($inquiries, fn (array $inquiry): bool => $inquiry['status'] === 'Converted to booking')),
            'visibleInquiryCount' => $visibleInquiryCount,
        ]);
    }
}
