<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

/**
 * @property int    $id
 * @property int    $user_id
 * @property string $provider
 * @property string $provider_id
 * @property Carbon $created_at
 */
class SocialLogin extends Model
{
    protected $table      = "social_logins";

    protected $guarded    = [];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Lấy data social của liên kết hiện tại
     *
     * @return array|null
     */
    public function getProviderDataAttribute(): array|null
    {
        $socialData = SocialDataUser::query()->where('user_id', $this->user_id)->first();
        if ($socialData) {
            $providerData = Arr::get($socialData->provider_data, $this->provider, []);
            return Arr::last($providerData);
        }
        return [];
    }
}
