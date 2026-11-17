<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $stageFilters = [
            'new-inquiry' => 'New inquiry',
            'pending-review' => 'Pending review',
            'awaiting-payment' => 'Awaiting payment',
            'confirmed' => 'Confirmed',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        $selectedStage = $request->query('stage');
        $selectedStage = is_string($selectedStage) && array_key_exists($selectedStage, $stageFilters)
            ? $selectedStage
            : '';
        $selectedStatus = $stageFilters[$selectedStage] ?? null;

        $statusClasses = [
            'New inquiry' => 'info',
            'Pending review' => 'warning',
            'Awaiting payment' => 'warning',
            'Confirmed' => 'success',
            'Completed' => 'primary',
            'Cancelled' => 'danger',
        ];

        $stageActions = [
            'New inquiry' => [
                ['label' => 'Start review', 'next_status' => 'Pending review', 'confirm' => 'Move this inquiry to review?'],
            ],
            'Pending review' => [
                ['label' => 'Approve and request payment', 'next_status' => 'Awaiting payment', 'confirm' => 'Approve this booking and request payment?'],
                ['label' => 'Decline inquiry', 'next_status' => 'Cancelled', 'confirm' => 'Decline and cancel this inquiry?', 'danger' => true],
            ],
            'Awaiting payment' => [
                ['label' => 'Confirm payment', 'next_status' => 'Confirmed', 'confirm' => 'Confirm that payment has been received?'],
                ['label' => 'Cancel booking', 'next_status' => 'Cancelled', 'confirm' => 'Cancel this booking?', 'danger' => true],
            ],
            'Confirmed' => [
                ['label' => 'Mark as completed', 'next_status' => 'Completed', 'confirm' => 'Mark this trip as completed?'],
                ['label' => 'Cancel booking', 'next_status' => 'Cancelled', 'confirm' => 'Cancel this booking?', 'danger' => true],
            ],
            'Completed' => [],
            'Cancelled' => [],
        ];

        $bookings = [
            [
                'reference' => 'ENH-2481',
                'customer' => 'Aarav Sharma',
                'email' => 'aarav.sharma@example.com',
                'package' => 'Everest Base Camp Trek',
                'travel_date' => '24 Oct, 2026',
                'guests' => 2,
                'total' => 'USD 2,450',
                'status' => 'Confirmed',
            ],
            [
                'reference' => 'ENH-2480',
                'customer' => 'Maya Gurung',
                'email' => 'maya.gurung@example.com',
                'package' => 'Annapurna Circuit',
                'travel_date' => '02 Nov, 2026',
                'guests' => 4,
                'total' => 'USD 3,200',
                'status' => 'Awaiting payment',
            ],
            [
                'reference' => 'ENH-2479',
                'customer' => 'Sophie Martin',
                'email' => 'sophie.martin@example.com',
                'package' => 'Chitwan Wildlife Safari',
                'travel_date' => '12 Nov, 2026',
                'guests' => 2,
                'total' => 'USD 680',
                'status' => 'Confirmed',
            ],
            [
                'reference' => 'ENH-2478',
                'customer' => 'Lucas Bernard',
                'email' => 'lucas.bernard@example.com',
                'package' => 'Kathmandu Valley Tour',
                'travel_date' => '18 Nov, 2026',
                'guests' => 3,
                'total' => 'USD 540',
                'status' => 'New inquiry',
            ],
            [
                'reference' => 'ENH-2477',
                'customer' => 'Emma Wilson',
                'email' => 'emma.wilson@example.com',
                'package' => 'Pokhara Adventure Escape',
                'travel_date' => '26 Nov, 2026',
                'guests' => 2,
                'total' => 'USD 890',
                'status' => 'Pending review',
            ],
            [
                'reference' => 'ENH-2476',
                'customer' => 'Noah Brown',
                'email' => 'noah.brown@example.com',
                'package' => 'Langtang Valley Trek',
                'travel_date' => '05 Dec, 2026',
                'guests' => 1,
                'total' => 'USD 1,150',
                'status' => 'Cancelled',
            ],
            [
                'reference' => 'ENH-2475',
                'customer' => 'Olivia Taylor',
                'email' => 'olivia.taylor@example.com',
                'package' => 'Kathmandu Heritage Walk',
                'travel_date' => '03 Oct, 2026',
                'guests' => 2,
                'total' => 'USD 420',
                'status' => 'Completed',
            ],
        ];

        $visibleBookingCount = $selectedStatus
            ? count(array_filter($bookings, fn (array $booking): bool => $booking['status'] === $selectedStatus))
            : count($bookings);

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'statusClasses' => $statusClasses,
            'stageActions' => $stageActions,
            'stageFilters' => $stageFilters,
            'selectedStatus' => $selectedStatus,
            'bookingCount' => count($bookings),
            'visibleBookingCount' => $visibleBookingCount,
            'confirmedCount' => count(array_filter($bookings, fn (array $booking): bool => $booking['status'] === 'Confirmed')),
            'awaitingCount' => count(array_filter($bookings, fn (array $booking): bool => in_array($booking['status'], ['Awaiting payment', 'Pending review'], true))),
            'inquiryCount' => count(array_filter($bookings, fn (array $booking): bool => $booking['status'] === 'New inquiry')),
        ]);
    }
}
