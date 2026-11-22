<?php

namespace App\Enums;

enum FaqCategory: string
{
    case Planning = 'planning';
    case Trekking = 'trekking';
    case Booking = 'booking';

    public function label(): string
    {
        return match ($this) {
            self::Planning => 'Trip planning',
            self::Trekking => 'Trekking in Nepal',
            self::Booking => 'Booking and payment',
        };
    }

    public function eyebrow(): string
    {
        return match ($this) {
            self::Planning => 'Start with the basics',
            self::Trekking => 'On the trail',
            self::Booking => 'Before you confirm',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Planning => 'Helpful details for shaping a trip around your time, interests and preferred pace.',
            self::Trekking => 'Preparation and practical details to consider before choosing a route.',
            self::Booking => 'What to expect when you enquire, confirm your trip and arrange payment.',
        };
    }
}
