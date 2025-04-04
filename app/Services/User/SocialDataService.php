<?php

namespace App\Services\User;

use App\Models\SocialDataUser;
use App\Models\SocialLogin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class SocialDataService
{
    /**
     * Lấy data social của user
     *
     * @param int $userId
     *
     * @return array|null
     */
    public static function getDataSocial(int $userId): array|null
    {
        return SocialDataUser::query()->where('user_id', $userId)->first()?->provider_data;
    }

    /**
     * Cập nhật data Social của user
     *
     * @param int $userId
     * @param array $data
     *
     * @return void
     */
    public static function updateOrCreateData(int $userId, array $data)
    {
        return SocialDataUser::updateOrCreate(
            ['user_id' => $userId],
            ['provider_data' => $data]
        );
    }

    /**
     * Tạo mới data khi liên kết lần đầu
     * Cập nhật data khi chưa có data hoặc mail social thay đổi
     * 
     * @param SocialLogin $socialLogin
     * @param array $socialUser
     *
     * @return void
     */
    public static function checkUpdateSocialData(?SocialLogin $socialLogin, array $socialUser): void
    {
        if ($socialLogin instanceof SocialLogin) {
            $provider            = $socialLogin->provider;
            $dataSocial          = static::getDataSocial($socialLogin->user_id);
            $dataProviderCurrent = Arr::get($dataSocial, $provider, []);
            try {
                $socialUser['updated_at'] = time();
                if ($dataProviderCurrent) {
                    // check data cũ với data hiện tại
                    $emailLast = Arr::get(Arr::last($dataProviderCurrent), 'email', '');
                    if ($emailLast != Arr::get($socialUser, 'email')) {
                        $dataProviderCurrent[] = $socialUser;
                        $dataSocial[$provider] = $dataProviderCurrent;
                        static::updateOrCreateData($socialLogin->user_id, $dataSocial);
                    }
                } else {
                    // Tạo mới data 
                    $dataSocial[$provider][] = $socialUser;
                    static::updateOrCreateData($socialLogin->user_id, $dataSocial);
                }
            } catch (\Exception $e) {
                if (config('app.debug')) {
                    throw $e;
                }
                Log::error(format_log_message($e));
            }
        }
    }
}
