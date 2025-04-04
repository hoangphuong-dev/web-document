<?php

declare(strict_types=1);

namespace App\Enums\Document;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

/**
 * @method static static PREVIEW()
 */
final class EagerLoadScene extends Enum
{
    #[Description("Preview")]
    const PREVIEW = 'preview';
}
