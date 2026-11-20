<?php

namespace App\Enums;

enum PackageBookingLogEvent: string
{
    case Submitted = 'submitted';
    case StatusChanged = 'status_changed';
    case HistoryInitialized = 'history_initialized';
}
