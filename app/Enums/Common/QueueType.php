<?php

declare(strict_types=1);

namespace App\Enums\Common;

use BenSampo\Enum\Enum;

/**
 * @method static static SYSTEM()
 * @method static static EMAIL()
 * @method static static PROCESS_AI()
 * @method static static PAYMENT()
 */
final class QueueType extends Enum
{
    const SYSTEM     = 'system';
    const EMAIL      = 'email';
    const PROCESS_AI = 'process-ai';
    const PAYMENT    = 'payment';
}
