<?php

declare(strict_types=1);

namespace App\Enums\Payment;

use BenSampo\Enum\Enum;

/**
 * @method static static PC()
 * @method static static MOBILE()
 */
final class DeviceType extends Enum
{
    public const PC     = 1;
    public const MOBILE = 2;
}
