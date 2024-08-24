<?php

namespace App\Enums;

class VitalSignsUnit
{
    const TEMPERATURE_C = '°C';
    const TEMPERATURE_F = '°F';
    const HEART_RATE = 'bpm';
    const BLOOD_PRESSURE_cm = 'cmHg';
    const BLOOD_PRESSURE_mm = 'mmHg';
    const RESPIRATORY_RATE = 'rpm';
    const OXYGEN_SATURATION = '%';

    public static function getValues(): array
    {
        return [
            self::TEMPERATURE_C,
            self::TEMPERATURE_F,
            self::HEART_RATE,
            self::BLOOD_PRESSURE_cm,
            self::BLOOD_PRESSURE_mm,
            self::RESPIRATORY_RATE,
            self::OXYGEN_SATURATION
        ];
    }
}
