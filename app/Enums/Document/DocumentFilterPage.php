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
final class DocumentFilterPage extends Enum
{

    #[Description('Từ 1 đến 20 trang')]
    const PAGE_1  = 1;

    #[Description('Từ 21 đến 50 trang')]
    const PAGE_2  = 2;

    #[Description('Từ 50 đến 100 trang')]
    const PAGE_3  = 3;

    #[Description('Lớn hơn 100 trang')]
    const PAGE_4  = 4;

    public static function getDescription(mixed $value): string
    {
        if (in_array($value, DocumentFilterPage::getValues())) {
            return parent::getDescription((int)$value);
        }
        return 'Tất cả';
    }
}
