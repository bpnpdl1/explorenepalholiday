<?php

namespace App\Enums;

enum PackageBookingStatus: string
{
    case New = 'new';
    case Processing = 'processing';
    case Confirmed = 'confirmed';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Processing => 'Processing',
            self::Confirmed => 'Confirmed',
            self::Canceled => 'Canceled',
        };
    }

    /** @return array<string, string> */
    public static function badgeClasses(): array
    {
        return [
            self::New->value => 'info',
            self::Processing->value => 'warning',
            self::Confirmed->value => 'success',
            self::Canceled->value => 'danger',
        ];
    }

    /** @return array<self> */
    public function nextStatuses(): array
    {
        return match ($this) {
            self::New => [self::Processing, self::Canceled],
            self::Processing => [self::Confirmed, self::Canceled],
            self::Confirmed => [self::Canceled],
            self::Canceled => [],
        };
    }

    public function canTransitionTo(self $status): bool
    {
        return in_array($status, $this->nextStatuses(), true);
    }
}
