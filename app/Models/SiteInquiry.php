<?php

namespace App\Models;

use App\Enums\PackageInquiryStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'email', 'phone', 'interest', 'message', 'status'])]
class SiteInquiry extends Model
{
    protected function casts(): array
    {
        return [
            'status' => PackageInquiryStatus::class,
        ];
    }
}
