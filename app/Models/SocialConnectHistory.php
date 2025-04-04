<?php

namespace App\Models;

use App\Enums\User\ConnectStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $user_id
 * @property string $provider
 * @property string $provider_id
 * @property int $type_connect
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */

class SocialConnectHistory extends Model
{
    use HasFactory;

    protected $table      = "social_connect_histories";
    
    protected $guarded    = [];

    protected $casts = [
        'type_connect' => ConnectStatus::class,
    ];

}
