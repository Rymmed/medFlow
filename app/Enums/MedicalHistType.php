<?php

namespace App\Enums;

class MedicalHistType
{
    const FAMILIAL = 'Familial';
    const PERSONAL = 'Personnel';

    public static function getValues(): array
    {
        return [
            self::FAMILIAL,
            self::PERSONAL,
        ];
    }
}
