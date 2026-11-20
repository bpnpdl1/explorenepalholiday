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

    /** @return array<string, string> */
    public static function badgeClasses(): array
    {
        return [
            self::New->value => 'info',
            self::Contacted->value => 'success',
            self::Cancelled->value => 'secondary',
        ];
    }
}
