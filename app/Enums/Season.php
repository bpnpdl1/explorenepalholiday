<?php

namespace App\Enums;

enum Season: string
{
    case Autumn = 'autumn';
    case Spring = 'spring';
    case Winter = 'winter';
    case Monsoon = 'monsoon';

    public function label(): string
    {
        return match ($this) {
            self::Autumn => 'Autumn (Oct - Nov)',
            self::Spring => 'Spring (Mar - Apr)',
            self::Winter => 'Winter (Dec - Feb)',
            self::Monsoon => 'Monsoon (Jun - Sep)',
        };
    }
}
