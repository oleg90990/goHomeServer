<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class YesNo extends Enum
{
    const Yes = '1';
    const No = '0';
    const None = '_none';
}