<?php

declare(strict_types=1);

namespace App\Enums\Category;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Attributes\Description;

/**
 * @method static static DOCUMENT()
 * @method static static COLLECTION()
 */
final class CategoryType extends Enum
{
    #[Description('Tài liệu')]
    const DOCUMENT = 'document';

    #[Description('Bộ sưu tập')]
    const COLLECTION = 'collection';
}
