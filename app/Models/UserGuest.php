<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $ip_address
 * @property string $phone
 * @property int $doc_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class UserGuest extends Model
{
    protected $table   = 'user_guests';
    protected $guarded = [];

    protected static function boot(): void
    {
        parent::boot();
        self::creating(function (UserGuest $userGuest) {
            $userGuest->ip_address = get_user_ip_address();
        });
    }
}
