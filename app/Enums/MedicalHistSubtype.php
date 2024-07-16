<?php

namespace App\Enums;

class MedicalHistSubtype
{
    const MEDICAL = 'Medical';
    const SURGICAL = 'Surgical';

    public static function getValues(): array
    {
        return [
            self::MEDICAL,
            self::SURGICAL,
        ];
    }
}
