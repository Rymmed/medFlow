<?php

namespace App\Enums;

class MedicalHistSubtype
{
    const MEDICAL = 'Médical';
    const SURGICAL = 'Chirurgical';

    public static function getValues(): array
    {
        return [
            self::MEDICAL,
            self::SURGICAL,
        ];
    }
}
