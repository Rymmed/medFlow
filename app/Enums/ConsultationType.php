<?php

namespace App\Enums;

class ConsultationType
{
    const ONLINE = 'En ligne';
    const IN_PERSON = 'En cabinet';
    const HOME_SERVICE = 'Service à domicile';

    public static function getValues(): array
    {
        return [
            self::ONLINE,
            self::IN_PERSON,
            self::HOME_SERVICE,
        ];
    }
}
