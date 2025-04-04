<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property array $provider_data
 */
class SocialDataUser extends Model
{
    use HasFactory;

    protected $table = "social_data_users";

    protected $primaryKey = 'user_id';

    protected $guarded    = [];

    public $timestamps = false;

    protected $casts = [
        'provider_data' => 'array',
    ];
}
