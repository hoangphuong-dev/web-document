<?php

declare(strict_types=1);

namespace App\Enums\Payment\NotLogin;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

/**
 * @method static static PENDDING()
 * @method static static LACK()
 * @method static static ENOUGH()
 */
final class MoneyStatus extends Enum
{
    #[Description('Chưa thanh toán')]
    const PENDDING = 0;

    #[Description('Đủ tiền')]
    const ENOUGH = 1;

    #[Description('Thiếu tiền')]
    const LACK = 2;
}
