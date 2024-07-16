<?php

namespace App\Enums;

class ConsultationType
{
    const ONLINE = 'Online';
    const IN_PERSON = 'In person';
    const HOME_SERVICE = 'Home service';

    public static function getValues(): array
    {
        return [
            self::ONLINE,
            self::IN_PERSON,
            self::HOME_SERVICE,
        ];
    }
}
