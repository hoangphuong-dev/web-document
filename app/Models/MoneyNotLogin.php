<?php

namespace App\Models;

use App\Enums\Payment\NotLogin\MoneyStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Nạp tiền không đăng nhập
 *
 * @property int $id
 * @property string $guest_id
 * @property int $document_id Khóa ngoại bảng document
 * @property string $order_id
 * @property string $transaction_id
 * @property int $money_need
 * @property int $money
 * @property string $phone
 * @property string $email
 * @property DeviceType $device_type
 * @property int $ip
 * @property string $description
 * @property MoneyStatus $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MoneyNotLogin extends Model
{
    use HasFactory;

    protected $table      = "money_not_logins";

    protected $guarded    = [];

    protected $casts = [
        'status'      => MoneyStatus::class,
    ];

    public function document(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id', 'id');
    }
}
