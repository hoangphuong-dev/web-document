<?php

declare(strict_types=1);

namespace App\Enums\User;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

/**
 * @method static static GOOGLE()
 * @method static static FACEBOOK()
 * @method static static ZALO()
 * @method static static APPLE()
 */
final class SocialProvider extends Enum
{
    #[Description('Google')]
    const GOOGLE = 'google';

    #[Description('Facebook')]
    const FACEBOOK = 'facebook';
}
