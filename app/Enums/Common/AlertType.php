<?php

declare(strict_types=1);

namespace App\Enums\Common;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

/**
 * @method static static INFO()
 * @method static static SUCCESS()
 * @method static static WARNING()
 * @method static static ERROR()
 */
final class AlertType extends Enum
{
    #[Description('Lỗi')]
    const ERROR = 'error';

    #[Description('Thành công')]
    const SUCCESS = 'success';

    #[Description('Cảnh báo')]
    const WARNING = 'warning';

    #[Description('Thông tin')]
    const INFO = 'info';

    #[Description('Thông báo')]
    const NOTIFY = 'notify';
}
