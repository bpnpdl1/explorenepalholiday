<?php

namespace App\Actions\Admin\Inquiries;

use App\Enums\PackageInquiryStatus;
use App\Models\PackageInquiry;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListInquiriesAction
{
    /** @return array<string, mixed> */
    public function handle(Request $request): array
    {
        $statusValue = $request->query('status');
        $selectedStatus = is_string($statusValue) ? PackageInquiryStatus::tryFrom($statusValue) : null;
        $searchValue = $request->query('search');
        $search = is_string($searchValue) ? mb_substr(trim($searchValue), 0, 100) : '';
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

        return [
            'inquiries' => $query->orderByDesc('created_at')->orderByDesc('id')->paginate(20)->withQueryString(),
            'statuses' => PackageInquiryStatus::cases(),
            'statusClasses' => PackageInquiryStatus::badgeClasses(),
            'selectedStatus' => $selectedStatus,
            'selectedSource' => $selectedSource,
            'search' => $search,
            'inquiryCount' => (clone $allInquiries)->count(),
            'newCount' => (int) $statusCounts->get(PackageInquiryStatus::New->value, 0),
            'contactedCount' => (int) $statusCounts->get(PackageInquiryStatus::Contacted->value, 0),
            'cancelledCount' => (int) $statusCounts->get(PackageInquiryStatus::Cancelled->value, 0),
        ];
    }
}
