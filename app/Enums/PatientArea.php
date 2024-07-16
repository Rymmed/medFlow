<?php

namespace App\Enums;

class PatientArea
{
    const URBAN = 'Urban';
    const RURAL = 'Rural';

    public static function getValues(): array
    {
        return [
            self::URBAN,
            self::RURAL,
        ];
    }
}
