<?php

namespace App\Enums;

class UserRole
{
    const ADMIN = 'admin';
    const SUPER_ADMIN = 'super-admin';
    const DOCTOR = 'doctor';
    const PATIENT = 'patient';
    const ASSISTANT = 'assistant';

    public static function getValues(): array
    {
        return [
            self::ADMIN,
            self::SUPER_ADMIN,
            self::DOCTOR,
            self::PATIENT,
            self::ASSISTANT
        ];
    }
}
