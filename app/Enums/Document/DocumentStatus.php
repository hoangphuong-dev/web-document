<?php

declare(strict_types=1);

namespace App\Enums\Document;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

/**
 * @method static static WAIT_APPROVE()
 * @method static static APPROVED()
 * @method static static NOT_APPROVED()
 * @method static static USER_DELETE()
 * @method static static ADMIN_DELETE()
 * @method static static LACK_INFO()
 * @method static static DUPLICATE()
 */
final class DocumentStatus extends Enum
{
    #[Description("Chờ duyệt")]
    const WAIT_APPROVE = 1;

    #[Description("Được duyệt")]
    const APPROVED = 2;

    #[Description("Không được duyệt")]
    const NOT_APPROVED = 3;

    #[Description("User xóa")]
    const USER_DELETE = 4;

    #[Description("Admin xóa")]
    const ADMIN_DELETE = 5;

    #[Description("Thiếu thông tin")]
    const LACK_INFO = 6;

    #[Description("Bị trùng")]
    const DUPLICATE = 7;
}
