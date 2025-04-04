<?php

declare(strict_types=1);

namespace App\Enums\Document;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Attributes\Description;

/**
 * @method static static PAGE_1()
 * @method static static PAGE_2()
 * @method static static PAGE_3()
 * @method static static PAGE_4()
 */
final class DocumentFilterAdvanced extends Enum
{
    #[Description('Chứa từ khóa')]
    const ALL_PHRASE = 1;

    #[Description('Tìm bắt đầu bằng từ khóa')]
    const START_PHRASE = 2;

    #[Description('Tìm chính xác từ khóa')]
    const EXACT_PHRASE = 3;

    // #[Description('Ít nhất một từ')]
    // const ALITTLE_PHRASE = 4;

    public static function getDescription(mixed $value): string
    {
        if (in_array($value, DocumentFilterAdvanced::getValues())) {
            return parent::getDescription((int)$value);
        }
        return 'Tất cả các từ';
    }
}
