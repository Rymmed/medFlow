<?php

namespace App\Enums;

class AppointmentStatus
{
    const PENDING = 'En attente';
    const REFUSED = 'Refusé';
    const CONFIRMED = 'Confirmé';
    const CANCELLED = 'Annulé';
    const STARTED = 'Commencé';
    const COMPLETED = 'Completé';
    const PENDING_RESCHEDULE = 'Reporté';

    public static function getValues(): array
    {
        return [
            self::PENDING,
            self::REFUSED,
            self::CONFIRMED,
            self::CANCELLED,
            self::STARTED,
            self::COMPLETED,
            self::PENDING_RESCHEDULE
        ];
    }
}
