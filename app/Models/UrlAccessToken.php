<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Bảng lưu link tải tài liệu 
 * 
 * @property int $id
 * @property string $tokenable_id
 * @property string $url
 * @property string $token
 * @property int $num_used
 * @property Carbon $expired_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class UrlAccessToken extends Model
{
    use HasFactory;

    protected $table   = 'url_access_token';

    protected $guarded = [];
}
