<?php

namespace App\Services\Document;

use App\Enums\Common\AlertType;
use App\Enums\Document\ConvertStatus;
use App\Enums\Document\DocumentStatus;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class DocumentViewService
{
    /**
     * Lấy lỗi của tài liệu
     *
     * @param Document $document
     * @return array
     */
    public static function getErrorMessage(Document $document): array
    {
        if ($document->isPublic()) {
            return [];
        }

        return match ($document->convert_status->value) {
            ConvertStatus::INIT   => [
                'alertType' => AlertType::WARNING,
                'alert'     => __('Tài liệu đang chờ convert ...'),
                'canView'   => false,
            ],
            ConvertStatus::ERROR => [
                'alertType' => AlertType::ERROR,
                'alert'     => 'Có lỗi xảy ra trong quá trình convert!',
                'canView'   => false,
            ],
            default                     => call_user_func(function () use ($document) {
                [$alert, $canView] = array_values(self::matchStatusDocument($document->status->value));
                return [
                    'alertType' => AlertType::WARNING,
                    'alert'     => $alert,
                    'canView'   => $canView || Auth::user()?->isAdmin(),
                ];
            }),
        };
    }

    /**
     * Lấy trạng thái tài liệu
     *
     * @param int $documentStatus
     * @return array
     */
    public static function matchStatusDocument(int $documentStatus): array
    {
        return match ($documentStatus) {
            DocumentStatus::WAIT_APPROVE => [
                'alert'   => __('Tài liệu này đang chờ ban quản trị duyệt!'),
                'canView' => true,
            ],
            DocumentStatus::DUPLICATE    => [
                'alert'   => __('Tài liệu này trùng với tài liệu khác!'),
                'canView' => true,
            ],
            DocumentStatus::NOT_APPROVED => [
                'alert'   => __('Tài liệu này không được ban quản trị duyệt!'),
                'canView' => true,
            ],
            DocumentStatus::USER_DELETE  => [
                'alert'   => __('Tài liệu do user tự xóa!'),
                'canView' => false,
            ],
            DocumentStatus::ADMIN_DELETE => [
                'alert'   => __('Tài liệu do admin xóa!'),
                'canView' => false,
            ],
            DocumentStatus::LACK_INFO    => [
                'alert'   => __('Tài liệu thiếu thông tin!'),
                'canView' => false,
            ],
            default                 => [
                'alert'   => 'Lỗi không xác định, Tài liệu chưa public!',
                'canView' => true,
            ],
        };
    }
}
