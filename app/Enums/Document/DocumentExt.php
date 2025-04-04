<?php

declare(strict_types=1);

namespace App\Enums\Document;

use App\Attributes\Icon;
use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

/**
 * @method static static PDF()
 * @method static static DOCX()
 */
final class DocumentExt extends Enum
{
    public string $icon;

    #[Description('PDF')]
    #[Icon('pdf-ext')]
    const pdf  = 1;

    #[Description('DOCX')]
    #[Icon('word-ext')]
    const docx = 2;

    public static function getDescription(mixed $value): string
    {
        if (in_array($value, DocumentExt::getValues())) {
            return parent::getDescription((int)$value);
        }
        return 'Tất cả';
    }

    public function __construct(mixed $enumValue)
    {
        parent::__construct($enumValue);
        $this->icon = self::getAttributeIcon($enumValue);
    }
}
