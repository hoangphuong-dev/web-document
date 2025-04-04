<?php

namespace App\Helpers;

class ImageHelper
{
    public static function getSvg(string $nameFile): string
    {
        return url("/images/icon/{$nameFile}.svg");
    }

    public static function getImageDefault($type): string
    {
        $url = match ($type) {
            'user' => '/images/user-avatar.png',
            'doc'  => '/images/doc-avatar.jpg',
        };
        return url($url);
    }
}
