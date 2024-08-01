<?php

namespace App\Enums;

class BloodGroup
{
    const A_POS ='A+';
    const A_NEG ='A-';
    const B_POS ='B+';
    const B_NEG ='B-';
    const AB_POS ='AB+';
    const AB_NEG ='AB-';
    const O_POS ='O+';
    const O_NEG ='O-';

    public static function getValues(): array
    {
        return [
            self::A_POS,
            self::A_NEG,
            self::B_POS,
            self::B_NEG,
            self::AB_POS,
            self::AB_NEG,
            self::O_POS,
            self::O_NEG,
       ];
    }
}
