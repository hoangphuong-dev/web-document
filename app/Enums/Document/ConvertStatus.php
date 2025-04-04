<?php

declare(strict_types=1);

namespace App\Enums\Document;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

/**
 * @method static static INIT()
 * @method static static SUCCESS()
 * @method static static ERROR()
 */
final class ConvertStatus extends Enum
{
    #[Description("Chờ convert")]
    const INIT = 0;

    #[Description("Convert thành công")]
    const SUCCESS = 1;

    #[Description("Convert lỗi")]
    const ERROR = 2;
}
