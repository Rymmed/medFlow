<?php

namespace App\Enums;

class Gender
{
    const MALE = '0';
    const FEMALE = '1';

    public static function getValues(): array
    {
        return [
            self::MALE,
            self::FEMALE,
        ];
    }
}
