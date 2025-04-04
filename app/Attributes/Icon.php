<?php

declare(strict_types=1);

namespace App\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS_CONSTANT | \Attribute::TARGET_CLASS)]
class Icon
{
    public function __construct(
        public string $icon,
    ) {}
}
