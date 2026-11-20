<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PackageInquiryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePackageInquiryStatusRequest;
use App\Models\PackageInquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request): View
    {
        $statusValue = $request->query('status');
        $selectedStatus = is_string($statusValue)
            ? PackageInquiryStatus::tryFrom($statusValue)
            : null;
        $search = is_string($request->query('search'))
            ? mb_substr(trim($request->query('search')), 0, 100)
            : '';

        $query = PackageInquiry::query()
            ->with(['package.departures', 'package.seasons'])
            ->latest();

        if ($selectedStatus) {
            $query->where('status', $selectedStatus->value);
        }

        if ($search !== '') {
            $query->where(function (Builder $query) use ($search): void {
                $query
                    ->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhereHas('package', fn (Builder $packageQuery) => $packageQuery->where('name', 'like', "%{$search}%"));
            });
        }

        $statusCounts = PackageInquiry::query()
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return view('admin.inquiries.index', [
            'inquiries' => $query->paginate(20)->withQueryString(),
            'statuses' => PackageInquiryStatus::cases(),
            'statusClasses' => $this->statusClasses(),
            'selectedStatus' => $selectedStatus,
            'search' => $search,
            'inquiryCount' => PackageInquiry::query()->count(),
            'newCount' => (int) $statusCounts->get(PackageInquiryStatus::New->value, 0),
            'contactedCount' => (int) $statusCounts->get(PackageInquiryStatus::Contacted->value, 0),
            'cancelledCount' => (int) $statusCounts->get(PackageInquiryStatus::Cancelled->value, 0),
        ]);
    }

    public function show(PackageInquiry $packageInquiry): View
    {
        $packageInquiry->load(['package.departures', 'package.seasons']);

        return view('admin.inquiries.show', [
            'inquiry' => $packageInquiry,
            'statuses' => PackageInquiryStatus::cases(),
            'statusClasses' => $this->statusClasses(),
        ]);
    }

    public function updateStatus(
        UpdatePackageInquiryStatusRequest $request,
        PackageInquiry $packageInquiry,
    ): RedirectResponse {
        $packageInquiry->status = PackageInquiryStatus::from($request->validated('status'));
        $packageInquiry->save();

        return back()->with('success', 'Inquiry status updated.');
    }

    /**
     * @return array<string, string>
     */
    private function statusClasses(): array
    {
        return [
            PackageInquiryStatus::New->value => 'info',
            PackageInquiryStatus::Contacted->value => 'success',
            PackageInquiryStatus::Cancelled->value => 'secondary',
        ];
    }
}
