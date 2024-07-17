<?php

namespace App\Enums;

class PatientArea
{
    const URBAN = 'Urbaine';
    const RURAL = 'Rurale';

    public static function getValues(): array
    {
        return [
            self::URBAN,
            self::RURAL,
        ];
    }
}
