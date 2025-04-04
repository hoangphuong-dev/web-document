<?php

declare(strict_types=1);

namespace App\Enums\Document;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Attributes\Description;

/**
 * @method static static MOI_DANG()
 * @method static static TAI_NHIEU()
 * @method static static XEM_NHIEU()
 */
final class DocumentSort extends Enum
{

    #[Description('Mới đăng')]
    const MOI_DANG  = 1;

    #[Description('Tải nhiều')]
    const TAI_NHIEU  = 2;

    #[Description('Xem nhiều')]
    const XEM_NHIEU  = 3;

    public static function getDescription(mixed $value): string
    {
        if (in_array($value, DocumentSort::getValues())) {
            return parent::getDescription((int)$value);
        }
        return 'Tất cả';
    }
}
