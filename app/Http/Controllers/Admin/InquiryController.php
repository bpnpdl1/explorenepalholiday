<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PackageInquiryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePackageInquiryStatusRequest;
use App\Models\PackageInquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $sourceValue = $request->query('source');
        $selectedSource = in_array($sourceValue, ['package', 'website'], true) ? $sourceValue : null;

        $packageInquiries = PackageInquiry::query()
            ->leftJoin('packages', 'packages.id', '=', 'package_inquiries.package_id')
            ->selectRaw("'package' as source")
            ->addSelect([
                'package_inquiries.id',
                'package_inquiries.customer_name as name',
                'package_inquiries.email',
                'package_inquiries.phone',
                'package_inquiries.status',
                'package_inquiries.created_at',
                'package_inquiries.message',
                'package_inquiries.travel_window',
                'packages.name as package_name',
                DB::raw('NULL as interest'),
            ]);

        $websiteInquiries = DB::table('site_inquiries')
            ->selectRaw("'website' as source")
            ->addSelect([
                'id',
                'name',
                'email',
                'phone',
                'status',
                'created_at',
                'message',
                DB::raw('NULL as travel_window'),
                DB::raw('NULL as package_name'),
                'interest',
            ]);

        $unionQuery = $packageInquiries->unionAll($websiteInquiries);
        $allInquiries = DB::query()->fromSub(clone $unionQuery, 'inquiries');
        $query = DB::query()->fromSub(clone $unionQuery, 'inquiries');

        if ($selectedStatus) {
            $query->where('status', $selectedStatus->value);
        }

        if ($selectedSource) {
            $query->where('source', $selectedSource);
        }

        if ($search !== '') {
            $query->where(function (Builder $query) use ($search): void {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhere('package_name', 'like', "%{$search}%")
                    ->orWhere('interest', 'like', "%{$search}%");
            });
        }

        $statusCounts = (clone $allInquiries)
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return view('admin.inquiries.index', [
            'inquiries' => $query->orderByDesc('created_at')->orderByDesc('id')->paginate(20)->withQueryString(),
            'statuses' => PackageInquiryStatus::cases(),
            'statusClasses' => $this->statusClasses(),
            'selectedStatus' => $selectedStatus,
            'selectedSource' => $selectedSource,
            'search' => $search,
            'inquiryCount' => (clone $allInquiries)->count(),
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
