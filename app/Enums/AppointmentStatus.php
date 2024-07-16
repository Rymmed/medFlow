<?php

namespace App\Enums;

class AppointmentStatus
{
    const PENDING = 'Pending';
    const REFUSED = 'Refused';
    const CONFIRMED = 'Confirmed';
    const CANCELLED = 'Cancelled';
    const STARTED = 'Started';
    const COMPLETED = 'Completed';

    public static function getValues(): array
    {
        return [
            self::PENDING,
            self::REFUSED,
            self::CONFIRMED,
            self::CANCELLED,
            self::STARTED,
            self::COMPLETED,
        ];
    }
}
