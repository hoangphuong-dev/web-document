<?php

namespace App\Data\Payment;

use App\Enums\Payment\DeviceType;

class RequestNotLoginData
{
    /** Phiên làm việc của user không đăng nhập */
    public int|string $guestId;

    /** ID tài liệu */
    public int $docId;

    /** Số điện thoại đặt hàng */
    public string $phone;

    /** Email đặt hàng (có thể trống) */
    public string $email;

    /** Loại thiết bị khi request DeviceType */
    public int $deviceType;

    public function __construct(
        int $guestId,
        int $docId,
        string $phone = '',
        string $email = '',
        int $deviceType = DeviceType::PC,
    ) {
        $this->guestId = $guestId;

        $this->docId = $docId;

        $this->phone = $phone;

        $this->email = $email;

        $this->deviceType = $deviceType;
    }
}
