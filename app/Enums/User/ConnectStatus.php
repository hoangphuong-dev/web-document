<?php

declare(strict_types=1);

namespace App\Enums\User;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

/**
 * @method static static UN_CONNECT()
 * @method static static CONNECT()
 * @method static static ADMIN_UN_CONNECT()
 * @method static static ADMIN_CONNECT()
 */
final class ConnectStatus extends Enum
{
    #[Description('UN_CONNECT')]
    public const UN_CONNECT = 0;

    #[Description('CONNECT')]
    public const CONNECT = 1;

    #[Description('Admin hủy liên kết')]
    public const ADMIN_UN_CONNECT = 2;

    #[Description('Admin liên kết')]
    public const ADMIN_CONNECT = 3;
}
