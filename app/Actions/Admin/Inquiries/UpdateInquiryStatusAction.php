<?php

namespace App\Actions\Admin\Inquiries;

use App\Enums\PackageInquiryStatus;
use App\Models\PackageInquiry;
use App\Models\SiteInquiry;

class UpdateInquiryStatusAction
{
    public function handle(PackageInquiry|SiteInquiry $inquiry, PackageInquiryStatus $status): void
    {
        $inquiry->status = $status;
        $inquiry->save();
    }
}
