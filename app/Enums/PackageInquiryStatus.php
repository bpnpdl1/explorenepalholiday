<?php

namespace App\Enums;

enum PackageInquiryStatus: string
{
    case New = 'new';
    case Contacted = 'contacted';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Contacted => 'Contacted',
            self::Cancelled => 'Cancelled',
        };
    }
}
