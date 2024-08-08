<?php

namespace App\Enums;

class VitalSignsType
{
    const TEMPERATURE = 'temperature';
    const HEART_RATE = 'fréquence cardiaque';
    const BLOOD_PRESSURE = 'pression artérielle';
    const RESPIRATORY_RATE = 'fréquence respiratoire';

    public static function getValues(): array
    {
        return [
            self::TEMPERATURE,
            self::HEART_RATE,
            self::BLOOD_PRESSURE,
            self::RESPIRATORY_RATE,
        ];
    }
}
